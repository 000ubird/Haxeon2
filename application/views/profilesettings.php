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
    echo form_open_multipart('profile/do_upload/'.$userID);
    //アイコン
    echo '<form action="#">';
    echo '<div class="file-field input-field">';
    echo '<div class="btn">';
    echo '<span>icon</span>';
    echo '<input type="file" name="userfile"/>';
    echo '</div>';
    echo '<div class="file-path-wrapper">';
    echo '<input class="file-path validate" type="text" />';
    echo '</div>';
    echo '</div>';
    echo '<input type="submit" value="upload" />';
    echo form_close();

    echo form_open('profile/validation_profile/'.$userID);

    echo '<div class="row">';
    echo '<div class="input-field col s12">';
    echo '<input name="userName" type="text">';
    echo '<label for="userName">userName</label>';
    echo '</div>';
    echo form_error('userName');
    echo '</div>';

    //メッセージ文
    echo '<div class="row">';
    echo '<div class="input-field col s12">';
    echo '<input name="profile" type="text">';
    echo '<label for="profile">message</label>';
    echo '</div>';
    echo form_error('profile');
    echo '</div>';

    echo '<div class="row">';
    echo '<button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">Change';
    echo '<i class="material-icons">open_in_new</i>';
    echo '</button>';
    echo '</div>';

    echo form_close();
    ?>
</div>

<div id="important" class="col s12">
    <?php
    echo '<div class="row">';
    echo '<button class="btn waves-effect waves-light orange darken-4 col s4 offset-s4" value="パスワードを変更する" onClick="location.href=\''. base_url() .'profile/change_pass/'. $userID .'\'">パスワードを変更する';
    echo '<i class="material-icons left">open_in_new</i>';
    echo '</button>';
    echo '</div>';

    echo '<div class="row">';
    echo '<button class="btn waves-effect waves-light orange darken-4 col s4 offset-s4" value="メールアドレスを変更する" onClick="location.href=\'https://www.google.co.jp\'">メールアドレスを変更する';
    echo '<i class="material-icons left">open_in_new</i>';
    echo '</button>';
    echo '</div>';

    echo '<div class="row">';
    echo '<button class="btn waves-effect waves-light red col s4 offset-s4" value="アカウントを削除する" onClick="location.href=\'http://localhost/haxeon2/profile/delete\'">アカウントを削除する';
    echo '<i class="material-icons left">delete</i>';
    echo '</button>';
    echo '</div>';

    ?>
</div>
