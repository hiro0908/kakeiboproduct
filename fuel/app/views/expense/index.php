<h1>支出一覧（<?=e($filter_year)?>年<?=e($filter_month)?>月）</h1>
<p><a href="<?=\Uri::create("expense/new")?>">新規追加</a></p>
<form method="get" action="<?=Uri::create("expense")?>">
    <label>
        <select name="per_page" onchange="this.form.submit()">
            <?php foreach(array(10,50,100)as $n):?>
                <option value="<?=$n?>" <?=$n==$filter_per_page?"selected":""?>><?=$n?>件</option>
            <?php endforeach;?>
        </select>
    </label>
    <label>
        <input type="number" name="year" value="<?=e($filter_year) ?>">
    </label>
    <label>
        <input type="number" name="month" value="<?=e($filter_month)?>">
    </label>
    <label>
        <select name="category_id">
            <option value="">すべて</option>
            <?php foreach($categories as $c):?>
                <option value="<?=$c["id"]?>"<?=$c["id"]==$filter_category_id?"selected":""?>><?=e($c["name"])?></option>
            <?php endforeach;?>
        </select>
    </label>
    <button type="submit">絞り込む</button>
</form>
<ul>
    <?php foreach($category_totals as $ct):?>
        <li><?=e($ct["name"])?>:<?=number_format($ct["total"])?>円</li>
    <?php endforeach;?>
</ul>
<p>
    並び替え:
    <a href="<?=\Uri::create("expense",array(),array("year"=>$filter_year,"month"=>$filter_month,"category_id"=>$filter_category_id,"sort"=>"date","dir"=>($sort_key=="date" and $sort_dir=="asc")?"desc":"asc"))?>">日付</a>
    /
    <a href="<?=\Uri::create("expense",array(),array("year"=>$filter_year,"month"=>$filter_month,"category_id"=>$filter_category_id,"sort"=>"amount","dir"=>($sort_key=="amount" and $sort_dir=="asc")?"desc":"asc"))?>">金額</a>
    
</p>
<div id="app">
    <table>
        <tr>
            <th>日付</th>
            <th>タイトル</th>
            <th>カテゴリ</th>
            <th>金額</th>
            <th>メモ</th>
            <th></th>
        </tr>
        <tr data-bind="visible:expenses().length===0">
            <td colspan="6">データがありません</td>
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
        <?=json_encode($expenses,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP)?>,
        <?=json_encode(\Config::get("security.csrf_token_key"))?>,
        <?=json_encode(\Security::fetch_token())?>
    );
    ko.applyBindings(vm,document.getElementById("app"));
</script>