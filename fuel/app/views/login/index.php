<h1>ログイン</h1>
<?php if (!empty($errors)):?>
    <ul>
        <?php foreach ($errors as $e):?>
            <li><?= $e ?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<form method="post" action=<?=\Uri::create("login")?>>
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?= \Security::fetch_token()?>">
    <label>ユーザー名
        <input type="text" name="username" value="<?= isset($username)?$username:""?>">
    </label>
    <label>パスワード
        <input type="password" name="password">
    </label>
    <button type="submit">ログイン</button>
</form>