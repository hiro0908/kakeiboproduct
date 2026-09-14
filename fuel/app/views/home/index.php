<p>ようこそ、<?=e($current_user["username"])?>さん</p>
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
<h2>月ごとの利用状況</h2>
<div class="bar-chart">
    <?php
    $max = max(array_column($monthly_totals, "total")) ?: 1;
    foreach ($monthly_totals as $m):
        $height = $m["total"] > 0 ? max(4, round($m["total"] / $max * 150)) : 0;
    ?>
        <div class="bar-item">
            <div class="bar" style="height:<?= $height ?>px;" title="<?= number_format($m["total"]) ?>円"></div>
            <span class="bar-value"><?= number_format($m["total"]) ?></span>
            <span class="bar-label"><?= e($m["label"]) ?></span>
        </div>
    <?php endforeach; ?>
</div>

<p><a href="<?=\Uri::create("budget")?>">支出目標を変更する</a></p>