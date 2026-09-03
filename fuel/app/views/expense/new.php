<h1>支出の新規登録</h1>
<?php if(!empty($errors)):?>
    <ul>
        <?php foreach ($errors as $e):?>
            <li><?=$e?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<form method="post" action="<?=\Uri::create("expense/new")?>">
    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label>タイトル
        <input type="text" name="title" value="<?=\Input::post("title")?>">
    </label>
    <label>金額
        <input type="number" name="amount" value="<?=\Input::post("amount")?>">
    </label>
    <label>カテゴリ
        <select name="category_id">
            <?php foreach ($categories as $c):?>
                <option value="<?=$c["id"]?>"><?=$c["name"]?></option>
            <?php endforeach;?>
        </select>
    </label>
    <label>支出日
        <input type="date" name="expense_date" value="<?=date("Y-m-d")?>">
    </label>
    <label>メモ
        <textarea name="memo"><?=\Input::post("memo")?></textarea>
    </label>
    <button type="submit">登録</button>
</form>