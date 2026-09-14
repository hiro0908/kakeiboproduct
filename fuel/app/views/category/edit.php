<h1>カテゴリ編集</h1>
<?php if(!empty($errors)):?>
    <ul>
        <?php foreach($errors as $e):?>
            <li><?=e($e)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<form method = "post" action="<?=\Uri::create("category/{$category["id"]}/edit")?>">
    <input type="hidden" name="<?=Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label> カテゴリ名
        <input type="text" name="name" value="<?=e($category["name"])?>">
    </label>
    <button type="submit">更新</button>
</form>