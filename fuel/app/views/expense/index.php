<h1>支出一覧</h1>
<a href="<?=Uri::create("expense/new")?>">新規登録</a>
<table>
    <tr>
        <th>日付</th>
        <th>タイトル</th>
        <th>カテゴリ</th>
        <th>金額</th>
        <th>メモ</th>
        <th></th>
    </tr>
    <?php foreach ($expenses as $e):?>
        <tr>
            <td><?= $e["expense_date"]?></td>
            <td><?= $e["title"]?></td>
            <td><?= $e["category_name"]?></td>
            <td><?= $e["amount"]?></td>
            <td><?= $e["memo"]?></td>
            <td>
                <a href="<?=Uri::create("expense/{$e["id"]}/edit")?>">編集</a>
                <form method="post" action="<?=uri::create("expense/{$e["id"]}/delete")?>">
                    <input type="hidden" name="<?=\Config::get("security.csrf_token_key")?>" value="<?=\Security::fetch_token()?>">
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
    <?php endforeach;?>
</table>