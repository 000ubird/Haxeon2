package api;

#if php
import api.Completion.CompletionResult;
import api.Completion.CompletionType;
import php.Web;
import Sys;
import php.Lib;
import sys.FileSystem;
import sys.io.File;

import sys.db.Connection;
import sys.db.Manager;
import sys.db.Mysql;
import sys.db.Sqlite;
#end

using StringTools;
using Lambda;

typedef HTMLConf =
{
	head:Array<String>,
	body:Array<String>
}

class Compiler {
	public static var isFirstClick = false;
	
	var tmpID : String;
	var tmpDir : String;
	var mainFile : String;
	public static var haxePath = "";
	
	public function new() {
		//サーバーのOSを取得し、コンパイラのパスを指定
		var os = Sys.systemName();
		switch (os) {
			case "Windows" : 
				haxePath = "C:/HaxeToolkit/haxe/haxe.exe";
			case "Linux" : 
				haxePath = "/usr/bin/haxe";
			default : 
				throw "Error";
		}
	}

	static function checkMacros( s : String ){
		var forbidden = [
			~/@([^:]*):([\/*a-zA-Z\s]*)(macro|build|autoBuild|file|audio|bitmap|font)/,
			~/macro/
		];
		for( f in forbidden ) if( f.match( s ) ) throw "Unauthorized macro : "+f.matched(0)+"";
	}

	public function prepareProgram( program : Program ) {
		if (program.uid == null) isFirstClick = true;
		else isFirstClick = false;

		tmpID = program.uid;
		program.uid = null;

		while( program.uid == null ){

			var id = haxe.crypto.Md5.encode( Std.string( Math.random() ) +Std.string( Date.now().getTime() ) );
			id = id.substr(0, 5);
			var uid = "";
			for (i in 0...id.length) uid += if (Math.random() > 0.5) id.charAt(i).toUpperCase() else id.charAt(i);

			var tmpDir = Api.tmp + '/$uid/';
			if( !(FileSystem.exists( tmpDir )) ){
				program.uid = uid;
			}
		}

		Api.checkSanity( program.uid );
		Api.checkSanity( program.main.name );
		Api.checkDCE( program.dce );

		tmpDir = Api.tmp + "/" + program.uid + "/";

		if( !FileSystem.isDirectory( tmpDir )){
			FileSystem.createDirectory( tmpDir );
		}

		mainFile = tmpDir + program.main.name + ".hx";

		var source = program.main.source;
		checkMacros( source );

		File.saveContent( mainFile , source );

		var s = program.main.source;
		program.main.source = null;
		File.saveContent( tmpDir + "program", haxe.Serializer.run(program));
		program.main.source = s;

	}

	//public function getProgram(uid:String):{p:Program, o:Program.Output}
	public function getProgram(uid:String):Program
	{
		Api.checkSanity(uid);

		if (FileSystem.isDirectory( Api.tmp + "/" + uid ))
		{
			tmpDir = Api.tmp + "/" + uid + "/";

			var s = File.getContent(tmpDir + "program");
			var p:Program = haxe.Unserializer.run(s);

			mainFile = tmpDir + p.main.name + ".hx";

			p.main.source = File.getContent(mainFile);

			/*
			var o:Program.Output = null;

			var htmlPath : String = tmpDir + "/" + "index.html";

			if (FileSystem.exists(htmlPath))
			{
				var runUrl = Api.base + "/program/"+p.uid+"/run";
				o = {
					uid : p.uid,
					stderr : null,
					stdout : "",
					args : [],
					errors : [],
					success : true,
					message : "Build success!",
					href : runUrl,
					source : ""
				}

				switch (p.target) {
					case JS(name):
					var outputPath = tmpDir + "/" + name + ".js";
					o.source = File.getContent(outputPath);
					default:
				}
			}
			*/
			//return {p:p, o:o};
			return p;
		}

		return null;
	}

	// TODO: topLevel competion
	public function autocomplete( program : Program , idx : Int ) : CompletionResult{

		try{
			prepareProgram( program );
		}catch(err:String){
			return {};
		}

		var source = program.main.source;
		var display = tmpDir + program.main.name + ".hx@" + idx;

		var args = [
			"-cp" , tmpDir,
			"-main" , program.main.name,
			"-v",
			"--display" , display
		];

		switch (program.target) {
			case JS(_):
				args.push("-js");
				args.push("dummy.js");

			case SWF(_, version):
				args.push("-swf");
				args.push("dummy.swf");
				args.push("-swf-version");
				args.push(Std.string(version));
		}

		addLibs(args, program);

		var out = runHaxe( args );

		try{
			var xml = new haxe.xml.Fast( Xml.parse( out.err ).firstChild() );

			if (xml.name == "type") {
				var res = xml.innerData.trim().htmlUnescape();
				res = res.replace(" ->", ",");
				if (res == "Dynamic") res = ""; // empty enum ctor completion
				var pos = res.lastIndexOf(","); // result type
				res = if (pos != -1) res.substr(0, pos) else "";
				if (res == "Void") res = ""; // no args methods

				return {type:res};
			}

			var words = [];
			for( e in xml.nodes.i ){
				var w = e.att.n;
				if( !words.has( w ) )
					words.push( w );

			}
			return {list:words};

		}catch(e:Dynamic){

		}

		return {errors:SourceTools.splitLines(out.err.replace(tmpDir, ""))};

	}

	function addLibs(args:Array<String>, program:Program, ?html:HTMLConf)
	{
		var availableLibs = Libs.getLibsConfig(program.target);
		for( l in availableLibs ){
			if( program.libs.has( l.name ) ){
				if (html != null)
				{
					if (l.head != null) html.head = html.head.concat(l.head);
					if (l.body != null) html.body = html.body.concat(l.body);
				}
				if (l.swf != null)
				{
					args.push("-swf-lib");
					args.push("../../lib/swf/" + l.swf.src);
				}
				else
				{
					args.push("-lib");
					args.push(l.name);
				}
				if( l.args != null )
					for( a in l.args ){
						args.push(a);
					}
			}
		}

	}

	public function compile( program : Program ){
		try{
			prepareProgram( program );
		}catch(err:String){
			return {
				uid : program.uid,
				args : [],
				stderr : err,
				stdout : "",
				errors : [err],
				success : false,
				message : "Build failure",
				href : "",
				source : "",
				embed : ""
			}
		}

		var args = [
			"-cp" , tmpDir,
			"-main" , program.main.name,
			"--times",
			"-dce", program.dce
			//"--dead-code-elimination"
		];

		var outputPath : String;
		var htmlPath : String = tmpDir + "index.html";
		var runUrl = '${Api.base}/program/${program.uid}/run';
		var embedSrc = '<iframe src="http://${Api.host}${Api.base}/embed/${program.uid}" width="100%" height="300" frameborder="no" allowfullscreen>
	<a href="http://${Api.host}/#${program.uid}">Try Haxe !</a>
</iframe>';

		var html:HTMLConf = {head:[], body:[]};

		switch( program.target ){
			case JS( name ):
				Api.checkSanity( name );
				outputPath = tmpDir + name + ".js";
				args.push( "-js" );
				args.push( outputPath );
				html.body.push("<script src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>");
				html.body.push("<script src='//markknol.github.io/console-log-viewer/console-log-viewer.js'></script>");
				html.body.push("<style type='text/css'>
					#debug_console {
						background:#fff;
						font-size:14px;
					}
					#debug_console font.log-normal {
						color:#000;
					}
					#debug_console a.log-button  {
						display:none;
					}
					</style>");


			case SWF( name , version ):
				Api.checkSanity( name );
				outputPath = tmpDir + name + ".swf";

				args.push( "-swf" );
				args.push( outputPath );
				args.push( "-swf-version" );
				args.push( Std.string( version ) );
				args.push("-debug");
				args.push("-D");
				args.push("advanced-telemetry"); // for Scout
				html.head.push("<link rel='stylesheet' href='"+Api.root+"/swf.css' type='text/css'/>");
				html.head.push("<script src='"+Api.root+"/lib/swfobject.js'></script>");
				html.head.push('<script type="text/javascript">swfobject.embedSWF("'+Api.base+"/"+StringTools.replace(outputPath,"../","")+'?r='+Math.random()+'", "flashContent", "100%", "100%", "'+version+'.0.0" , null , {} , {wmode:"direct", scale:"noscale"})</script>');
				html.body.push('<div id="flashContent"><p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p></div>');
		}

		addLibs(args, program, html);
		//trace(args);

		var out = runHaxe( args );
		var err = out.err.replace(tmpDir, "");
		var errors = SourceTools.splitLines(err);

		var output : Program.Output = if( out.exitCode == 0 ){
			{
				uid : program.uid,
				stderr : err,
				stdout : out.out,
				args : args,
				errors : [],
				success : true,
				message : "Build success!",
				href : runUrl,
				embed : embedSrc,
				source : ""
			}
		}else{
			{
				uid : program.uid,
				stderr : err,
				stdout : out.out,
				args : args,
				errors : errors,
				success : false,
				message : "Build failure",
				href : "",
				embed : "",
				source : ""
			}
		}

		//追加部分
		var userID = program.userID;
		var projectName = program.projectName;
		var originProjectID = program.originProjectID;
		var originUserID = program.originUserID;
		//html.body.push("<br><H3>生成されたID : " + program.uid +"\n 前のID : " + tmpID + "</H3>");

		//2回目以降のクリック時は更新されたプロジェクトIDを保存
		if (!isFirstClick) originProjectID = program.uid;
		
		var cnx = Mysql.connect( {
			host : "localhost",
			port : 3306,
			user : "root",
			pass : "DELL",
			database : "haxeon",
			socket : null
		} );
		//警告文出力の位置を調整
		html.body.push("<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>");
		html.body.push("<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>");
		
		//プロジェクトが登録されているかを確認
		var rset = cnx.request("SELECT projectID FROM project where (tmpPro = '" + tmpID + "' AND ownerUserID = '" + userID + "') OR (ownerUserID = '" + userID + "' AND projectID = '"+tmpID+"');");
		
		//プロジェクトが登録されていない場合
		if (rset.length == 0) {
			//html.body.push("<br><H3>プロジェクトIDなし</H3>");
			
			if (program.save == "SAVE" && userID != null) {
				//プロジェクトテーブルに追加
				cnx.request("INSERT INTO `project`(`projectID`, `tmpPro`, `projectName` ,`ownerUserID`, `pv`, `fork`, `originUserID`) VALUES (\""
				+program.uid + "\", \"" +program.uid+ "\", \"" + projectName+"\",\"" + userID + "\"," + 0 + "," + 0 + ", \"" + originUserID + "\");");
				
				//ランキングテーブルに追加
				cnx.request("INSERT INTO `day_ranking` (`proID`, `tmpPro`, `usrID`, `pv`) VALUES (\""+program.uid+"\",\""+program.uid+"\",\""+userID+"\", 0)");
				
				html.body.push("<br><H3>データベースにIDを登録しました。</H3>");
			//コードが保存されない場合の処理
			} else {
				//未ログイン状態の場合
				if (userID == null) {
					html.body.push("<font size=\"5\" color=\"#FF6600\">警告:未ログイン状態では現在のコードは保存されません。</font>");
				} 
				//未保存のチェックボックスが選択されている場合
				else {
					html.body.push("<font size=\"5\" color=\"#FF6600\">確認:現在、未保存が選択されています。</font>");
				}
			}

			//フォークの場合は元のプロジェクト所持者のフォーク数を1上げる
			//html.body.push("originpro : "+originProjectID+" ,originuserID : "+originUserID+", currentuser : "+userID);
			if (userID != originUserID && userID != null) {
				var fork = 0;
				var rset2 = cnx.request("SELECT * FROM project where projectID = '"+tmpID+"';");
				for (row in rset2) {
					fork = row.fork+1;
				}
				cnx.request("UPDATE project SET fork = "+fork+" WHERE projectID = '"+tmpID+"' AND ownerUserID = '"+originUserID+"';");
			}
		}
		//プロジェクトIDを更新
		else {
			//html.body.push("<br><H3>プロジェクトIDあり</H3>");
			//for (row in rset) {
			//	html.body.push("プロジェクトID : "+row.projectID+" , 所有者 : "+userID+" , プロジェクト名 : "+projectName);
			//}
			if (program.save == "SAVE" && userID != null) {
				cnx.request("UPDATE project SET tmpPro = \""+program.uid+"\",modified = \""+Date.now().toString()+"\" , projectID = \""+program.uid+"\" WHERE ownerUserID = '"+userID+"' AND tmpPro = '"+tmpID+"';");
				cnx.request("UPDATE day_ranking SET proID = \""+program.uid+"\" , tmpPro = \""+program.uid+"\" WHERE tmpPro = '"+tmpID+"';");
                cnx.request("UPDATE tagmap SET projectID = \""+program.uid+"\" WHERE projectID = '"+tmpID+"';");
			} else {
				cnx.request("UPDATE project SET tmpPro = \""+program.uid+"\",modified = \""+Date.now().toString()+"\" WHERE ownerUserID = '"+userID+"' AND tmpPro = '"+tmpID+"';");
				cnx.request("UPDATE day_ranking SET tmpPro = \""+program.uid+"\" WHERE tmpPro = '"+tmpID+"';");
				//未ログイン状態の場合
				if (userID == null) {
					html.body.push("<font size=\"5\" color=\"#FF6600\">警告:未ログイン状態では現在のコードは保存されません。</font>");
				} 
				//未保存のチェックボックスが選択されている場合
				else {
					html.body.push("<font size=\"5\" color=\"#FF6600\">確認:現在、未保存が選択されています。</font>");
				}
			}
		}
		cnx.close();
		//追加部分終了

		if (out.exitCode == 0)
		{
			switch (program.target) {
				case JS(_):
					output.source = File.getContent(outputPath);
					html.body.push("<script>" + output.source + "</script>");
				default:
			}
			var h = new StringBuf();
			h.add("<html>\n\t<head>\n\t\t<title>Haxe Run</title>");
			for (i in html.head) { h.add("\n\t\t"); h.add(i); }
			h.add("\n\t</head>\n\t<body>");
			for (i in html.body) { h.add("\n\t\t"); h.add(i); }
			h.add('\n\t</body>\n</html>');

			File.saveContent(htmlPath, h.toString());
		}
		else
		{
			if (FileSystem.exists(htmlPath)) FileSystem.deleteFile(htmlPath);
		}

		return output;
	}

	function runHaxe( args : Array<String> ){

		var proc = new sys.io.Process( haxePath , args );

		var exit = proc.exitCode();
		var out = proc.stdout.readAll().toString();
		var err = proc.stderr.readAll().toString();

		var o = {
			proc : proc,
			exitCode : exit,
			out : out,
			err : err
		};

		return o;

	}

}
