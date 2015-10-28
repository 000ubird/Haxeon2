<h2>プロフィール設定</h2>

<div class="row">
    <div class="col s12 orange darken-4">
        <ul class="tabs">
            <li class="tab col s6"><a class="active" href="#common">情報</a></li>
            <li class="tab col s6"><a href="#important">重要</a></li>
        </ul>
    </div>
</div>

<div id="common" class="col s12">
    <?php

    $uname = "";
    $url = "";
    $message = "";

    foreach($user as $row){
        $uname = $row->userName;
        $url = $row->userURL;
        $message = $row->userProfile;
    }

    echo form_open('profile/validation_profile/'.$userID);

    echo '<div class="row">';
    echo '<div class="input-field col s12">';
    echo '<input name="userName" type="text" value="'.$uname.'">';
    echo '<label for="userName">userName</label>';
    echo '</div>';

    echo form_error('userName');

    echo '</div>';

    echo '<div class="row">';
    echo '    <div class="input-field col s12">';
    echo '        <input name="url" type="text" value="'.$url.'">';
    echo '        <label for="url">URL</label>';
    echo '    </div>';

        echo form_error('url');

    echo '</div>';

    echo '<div class="row">';
    echo '<div class="input-field col s12">';
    echo '    <textarea name="profile" class="materialize-textarea" maxlength="140" placeholder="'.$message.'"></textarea>';
    echo '    <label for="profile">message</label>';
    echo '</div>';

    echo form_error('profile');

    echo '</div>';

    echo '<div class="row">';
    echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">Change';
    echo '<i class="material-icons">open_in_new</i>';
    echo '</button>';
    echo '</div>';


    echo form_close();


    echo '<br />';
    echo '<hr />';


    echo form_open_multipart('profile/icon_upload/'.$userID);
    ?>
<!-- アイコン-->
    <br />
    <div class="row">
        <div class="col s3">
            <?php
                $iconurl = "";
                foreach ($user as $row) {
                    $iconurl = $row->userIcon;
                }

            echo '<img src="'.$iconurl.'" width="100" height="100">';
             ?>
        </div>
        <div class="col s9">
            <form action="#">
            <div class="file-field input-field">
                <div class="btn">
                    <span>icon</span>
                    <input type="file" name="userfile"/>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" />
                </div>
            </div>
            <div class="row" align="right">
            <button class="btn waves-effect" type="submit" value="upload">upload
            </div>
            </form>
        </div>
    </div>
    </form>
</div>

<div id="important" class="col s12">

    <div class="row">
    <?php
    echo '<button class="btn waves-effect waves-light orange darken-4 col s4 offset-s4" value="パスワードを変更する" onClick="location.href=\''. base_url() .'profile/change_pass/'. $userID .'\'">パスワードを変更する';
    ?>
    <i class="material-icons left">lock_open</i>
    </button>
    </div>

    <div class="row">
    <?php
    echo '<button class="btn waves-effect waves-light orange darken-4 col s4 offset-s4" value="メールアドレスを変更する" onClick="location.href=\''. base_url() .'profile/change_email/'. $userID .'\'">メールアドレスを変更する';
    ?>
    <i class="material-icons left">email</i>
    </button>
    </div>

    <div class="row">
    <?php
	    echo '<button class="btn waves-effect waves-light red col s4 offset-s4" value="アカウントを削除する" onClick="location.href=\''. base_url() .'profile/delete\'">アカウントを削除する';
    ?>
    <i class="material-icons left">error_outline</i>
    </button>
    </div>

</div>
