<h1>カテゴリ設定</h1>
<?php if ($msg=\Session::get_flash("error")):?>
    <p><?=$msg?></p>
<?php endif;?>

<?php if(!empty($errors)):?>
    <ul>
        <?php foreach($errors as $e):?>
            <li><?=$e?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<h2>新しいカテゴリ</h2>
<form method="post" action="<?=Uri::create("category")?>">        
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label>カテゴリ名
        <input type="text" name="name">
    </label>
    <button type="submit">追加</button>
</form>
<h2>カテゴリ一覧</h2>
<ul>
    <?php foreach ($categories as $c):?>
        <li>
            <?=$c["name"]?>
            <a href="<?=\Uri::create("category/{$c["id"]}/edit")?>">編集</a>
            <form method="post" action="<?=\Uri::create("category/{$c["id"]}/delete")?>" style="display:inline">
                <input type="hidden" name="<?= Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
                <button type="submit">削除</button>
            </form>
        </li>
    <?php endforeach;?>
</ul>


