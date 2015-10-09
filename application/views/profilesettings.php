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
    echo form_open('profile/validation_profile/'.$userID);
?>
    <div class="row">
    <div class="input-field col s12">
    <input name="userName" type="text">
    <label for="userName">userName</label>
    </div>
    <?php
    echo form_error('userName');
    ?>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input name="url" type="text">
            <label for="url">URL</label>
        </div>
        <?php
        echo form_error('url');
        ?>
    </div>

<!--    メッセージ文-->
    <div class="row">
    <div class="input-field col s12">
    <input name="profile" type="text">
    <label for="profile">message</label>
    </div>
    <?php
    echo form_error('profile');
    ?>
    </div>

    <div class="row">
    <button class="btn waves-effect waves-light orange darken-4 col s3 offset-s9" type="submit" name="action">Change
    <i class="material-icons">open_in_new</i>
    </button>
    </div>

    <?php
    echo form_close();
    ?>

    <br />
    <hr />

    <?php
    echo form_open_multipart('profile/icon_upload/'.$userID);
    ?>
<!-- アイコン-->
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
    <input type="submit" value="upload" />
    <?php
    echo form_close();
    ?>
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
