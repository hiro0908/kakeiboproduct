<h1>設定</h1>
<h2>表示テーマ</h2>
<form method="post" action="<?=Uri::create("settings")?>">
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label>
        <input type="radio" name="theme" value="light" <?=$theme==="light"?"checked":""?>>ライト
    </label>
    <label>
        <input type="radio" name="theme" value = "dark" <?=$theme==="dark"?"checked":""?>>ダーク
    </label>
    <button type="submit">保存</button>
</form>

<h2>アカウント</h2>
<p><a href="<?=Uri::create("account")?>">アカウントを削除する</a></p>