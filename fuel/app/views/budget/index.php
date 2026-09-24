<h1>支出目標</h1>
<?php if(!empty($errors)):?>
    <ul>
        <?php foreach($errors as $e):?>
            <li><?=e($e)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<?php if($budget !== null):?>
    <p>今月の上限:<?=number_format($budget["amount"])?></p>
<?php else:?>
    <p>今月はまだ設定されていません</p>
<?php endif;?>

<form method = "post" action = "<?=\Uri::create("budget")?>">
    <input type = "hidden" name = "<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
    <label>上限金額
        <input type = "number" name = "amount" value = "<?=$budget !== null ? $budget["amount"] : "" ?>">
    </label>
    <button type = "submit"> 保存</button>
</form>