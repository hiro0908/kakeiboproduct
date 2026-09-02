<h1>新規登録</h1>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $e): ?>
            <li><?= $e ?></li>
        <?php endforeach?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= \Uri::create("register")?>">
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?= \security::fetch_token() ?>">
    <label>ユーザー名
        <input type="text" name="username" value="<?= isset($username)?$username:""?>">
    </label>
    <label>パスワード
        <input type="password" name="password">
    </label>
    <label>パスワード確認
        <input type="password" name="password_confirm">
    </label>
    <button type="submit">登録</button>
</form>