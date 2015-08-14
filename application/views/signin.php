<!-- バリデーションは設定していないので、形だけです。後付する予定 -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>sign in</title>
</head>
<body>
<form>
    <fieldset>
        <table>
            <tbody>
            <tr>
                <th>userID</th>
                <td><input type="text" id="userID" name="userID" value="" /></td>
            </tr>
            <tr>
                <th>password</th>
                <td><input type="text" id="password" name="password" value="" /></td>
            </tr>
            <tr>
                <th>password (確認)</th>
                <td><input type="text" id="check_password" name="check_password" value="" /></td>
            </tr>
            <tr>
                <th>mail</th>
                <td><input type="text" id="mail" name="mail" value="" /></td>
            </tr>
            <tr>
                <th>mail (確認)</th>
                <td><input type="text" id="check_mail" name="check_mail" value="" /></td>
            </tr>
            </tbody>
        </table>
    </fieldset>
<!--  submitしたら、メールを送った画面に遷移させたい  -->
    <p class="submit"><input type="submit" name="submit" value="login" /></p>
</form>
</body>
</html>
