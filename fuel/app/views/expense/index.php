<h1>支出一覧</h1>
<form method="get" action="<?=Uri::create("expense")?>">
    <label>
        <input type="number" name="year" value="<?=$filter_year ?>">
    </label>
    <label>
        <input type="number" name="month" value="<?=$filter_month?>">
    </label>
    <label>
        <select name="category_id">
            <option value="">すべて</option>
            <?php foreach($categories as $c):?>
                <option value="<?=$c["id"]?>"<?=$c["id"]==$filter_category_id?"selected":""?>><?=$c["name"]?></option>
            <?php endforeach;?>
        </select>
    </label>
    <button type="submit">絞り込む</button>
</form>
<h2>カテゴリ別集計</h2>
<ul>
    <?php foreach($category_totals as $ct):?>
        <li><?=$ct["name"]?>:<?=number_format($ct["total"])?>円</li>
    <?php endforeach;?>
</ul>
<p>
    並び替え:
    <a href="<?=\Uri::create("expense",array(),array("year"=>$filter_year,"month"=>$filter_month,"category_id"=>$filter_category_id,"sort"=>"date","dir"=>($sort_key=="date" and $sort_dir=="asc")?"desc":"asc"))?>">日付</a>
    /
    <a href="<?=\Uri::create("expense",array(),array("year"=>$filter_year,"month"=>$filter_month,"category_id"=>$filter_category_id,"sort"=>"amount","dir"=>($sort_key=="amount" and $sort_dir=="asc")?"desc":"asc"))?>">金額</a>
    
</p>
<div id="app">
    <p>合計：<span data-bind="text:total">円</span></p>
    <h2>新規登録</h2>
    <ul data-bind="foreach:errors">
        <li data-bind="text:$data"></li>    
    </ul>
        
    <label>タイトル
        <input type="text" data-bind="value:newTitle">
    </label>
    <label>金額
        <input type="number" data-bind="value:newAmount">
    </label>
    <button type="button" data-bind="click: function(){ addQuickAmount(100) }">+100円</button>
    <button type="button" data-bind="click: function(){ addQuickAmount(500) }">+500円</button>
    <button type="button" data-bind="click: function(){ addQuickAmount(1000) }">+1000円</button>
    <button type="button" data-bind="click: function(){ addQuickAmount(5000) }">+5000円</button>
    <button type="button" data-bind="click: function(){ addQuickAmount(10000) }">+10000円</button>

    <label>カテゴリ
        <select data-bind="value:newCategoryId">
            <?php foreach($categories as $c):?>
                <option value="<?= $c["id"]?>"><?= $c["name"]?></option>
            <?php endforeach;?>
        </select>
    </label>
    <label>支出日
        <input type="date" data-bind="value:newExpenseDate">
    </label>
    <label>メモ
        <textarea data-bind="value:newMemo"></textarea>
    </label>

    <button type="button" data-bind="click:createExpense">登録</button>
    <h2></h2>

    <table>
        <tr>
            <th>日付</th>
            <th>タイトル</th>
            <th>カテゴリ</th>
            <th>金額</th>
            <th>メモ</th>
            <th></th>
        </tr>
        <!-- ko foreach:expenses-->
        <tr data-bind="visible:!isEditing()">
            <td data-bind="text:expense_date"></td>
            <td data-bind="text:title"></td>
            <td data-bind="text:category_name"></td>
            <td data-bind="text:amount"></td>
            <td data-bind="text:memo"></td>
            <td>
                <button type="button" data-bind="click:$parent.startEdit">編集</button>
                <button type="button" data-bind="click:$parent.deleteExpense">削除</button>
            </td>
        </tr>
        <tr data-bind="visible:isEditing">
            <td><input type="date" data-bind="value:expense_date"></td>
            <td><input type="text" data-bind="value:title"></td>
            <td><input type="number" data-bind="value:category_id"></td>
            <td><input type="number" data-bind="value:amount"></td>
            <td><input type="text" data-bind="value:memo"></td>
            <td>
                <button type="button" data-bind="click:$parent.saveEdit">保存</button>
                <button type="button" data-bind="click:$parent.cancelEdit">キャンセル</button>
            </td>
        </tr>
        <!--/ko-->
    </table>
</div>
<script src="/assets/js/vendor/knockout-3.5.3.js"></script>
<script src="/assets/js/expense.js"></script>
<script>
    var vm=new ExpenseViewModel(
        <?=json_encode($expenses)?>,
        <?=json_encode(\Config::get("security.csrf_token_key"))?>,
        <?=json_encode(\Security::fetch_token())?>
    );
    ko.applyBindings(vm,document.getElementById("app"));
</script>