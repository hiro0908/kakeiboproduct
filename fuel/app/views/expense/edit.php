<h1>支出の編集</h1>
<?php if(!empty($errors)):?>
    <ul>
        <?php foreach($errors as $e):?>
            <li><?=e($e)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<form method="post" action="<?=\Uri::create("expense/{$expense["id"]}/edit")?>">
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label>タイトル
        <input type="text" name="title" value="<?=e($expense["title"])?>">
    </label>
    <label>金額
        <input type="number" name="amount" value="<?=$expense["amount"]?>">
    </label>
    <label>カテゴリ
        <select name="category_id">
            <?php foreach ($categories as $c):?>
                <option value="<?=$c["id"]?>"<?=$c["id"]==$expense["category_id"]?"selected":""?>><?=e($c["name"])?></option>
            <?php endforeach;?>
        </select>
    </label>
    <label>支出日
        <input type="date" name="expense_date" value="<?=$expense["expense_date"]?>">
    </label>
    <label>メモ
        <textarea name="memo"><?=e($expense["memo"])?></textarea>
    </label>
    <button type="submit">更新</button>
</form>