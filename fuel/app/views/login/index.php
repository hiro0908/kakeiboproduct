<?php if ($msg=\Session::get_flash("success")):?>
    <p><small><?=e($msg)?></small></p>
<?php endif;?>
<h1>ログイン</h1>
<?php if (!empty($errors)):?>
    <ul>
        <?php foreach ($errors as $e):?>
            <li><?= e($e )?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<form method="post" action=<?=\Uri::create("login")?>>
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?= \Security::fetch_token()?>">
    <label>ユーザー名
        <input type="text" name="username" value="<?= e(isset($username)?$username:"")?>">
    </label>
    <label>パスワード
        <input type="password" name="password">
    </label>
    <button type="submit">ログイン</button>
</form>
<p><a href="<?=Uri::create("register")?>">新規登録はこちら</a></p>