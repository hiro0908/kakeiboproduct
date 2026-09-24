<h1>アカウント削除</h1>
<p>本当に削除しますか？この操作は取り消せません</p>
<form method = "post" action = <?=\Uri::create("account")?>>
    <input type = "hidden" name = "<?=\Config::get("security.csrf_token_key")?>" value = "<?=\Security::fetch_token()?>">
    <button type = "submit">削除する</button>
</form>