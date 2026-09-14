<h1>支出の新規登録</h1>
<?php if(!empty($errors)):?>
    <ul>
        <?php foreach ($errors as $e):?>
            <li><?=e($e)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<div id="app">
    <form method="post" action="<?=\Uri::create("expense/new")?>">
        <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
        <label>タイトル
            <input type="text" name="title" value="<?=e(\Input::post("title"))?>">
        </label>
        <br><br>
        <label>金額
            <input type="number" name="amount" data-bind="value:amount">
        </label>
        <br>
        <button type="button" data-bind="click: function(){ addQuickAmount(100) }">+100円</button>
        <button type="button" data-bind="click: function(){ addQuickAmount(500) }">+500円</button>
        <button type="button" data-bind="click: function(){ addQuickAmount(1000) }">+1000円</button>
        <br>
        <button type="button" data-bind="click: function(){ addQuickAmount(5000) }">+5000円</button>
        <button type="button" data-bind="click: function(){ addQuickAmount(10000) }">+10000円</button>
        <br><br>
        <label>カテゴリ
            <select name="category_id">
                <?php foreach ($categories as $c):?>
                    <option value="<?=$c["id"]?>"><?=e($c["name"])?></option>
                <?php endforeach;?>
            </select>
        </label>
        <br><br>
        <label>支出日
            <input type="date" name="expense_date" value="<?=date("Y-m-d")?>">
        </label>
        <br><br>
        <label>メモ
            <textarea name="memo"><?=e(\Input::post("memo"))?></textarea>
        </label>
        <button type="submit">登録</button>
    </form>
</div>
<script src="/assets/js/vendor/knockout-3.5.3.js"></script>
<script>
    function NewExpenseViewModel(initialAmount){
        const self =this;
        self.amount=ko.observable(initialAmount||"");
        self.addQuickAmount=function(value){
            const current=Number(self.amount())||0;
            self.amount(current+value);
        }
    }
    ko.applyBindings(
        new NewExpenseViewModel(<?=json_encode(\Input::post("amount"))?>),
        document.getElementById("app")
    );
</script>