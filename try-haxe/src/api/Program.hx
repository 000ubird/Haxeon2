package api;

typedef Program = {
	uid : String,
	main : Module,
	target : Target,
	libs:Array<String>,
	dce : String,
//	?modules : Hash<Module>,
	
	//追加部分
	save : String,		//Editorの保存・非保存情報を取得する
	isPublic : String,	//Editorの公開非公開設定を取得する
	
	userID : String,			//現在編集中のユーザーID
	originUserID : String,		//フォーク元のユーザーID
	originProjectID : String,	//新しく生成する前のプロジェクトID
	projectName : String,		//プロジェクト名:不必要になる予定
	
}

typedef Module = {
	name : String,
	source : String
}

enum Target {
	JS( name : String );
	SWF( name : String , ?version : Float );
}

typedef Output = {
	uid : String,
	stderr : String,
	stdout : String,
	args : Array<String>,
	errors : Array<String>,
	success : Bool,
	message : String,
	href : String,
	source : String,
	embed : String
}
