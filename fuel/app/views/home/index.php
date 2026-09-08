<p>ようこそ、<?=$current_user["username"]?>さん</p>
<h2>今月の支出</h2>
<p>支出の合計:<?=number_format($summary["total"])?>円</p>
<?php if($summary["limit"]!==null):?>
    <p>上限:<?=number_format($summary["limit"])?>円</p>
    <p>使用率:<?=$summary["percentage"]?>%</p>

    <?php if($summary["is_over"]):?>
        <p style="color:red;">上限を超えています</p>
    <?php elseif($summary["is_warning"]):?>
        <p style="color:orange;">支出上限に近づいています</p>
    <?php endif;?>
<?php else:?>
    <p>今月の支出上限がまだ設定されていません</p>
<?php endif;?>
<p><a href="<?=\Uri::create("budget")?>">支出目標を変更する</a></p>