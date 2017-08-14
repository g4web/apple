<?php

use backend\widgets\apple\AppleWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->registerCssFile('/my/apple/css/apple.css');
$this->registerJsFile('/my/apple/js/apple.js');
?>
<?php
/* @var backend\models\Apple $apple */
foreach ($appleCollection as $apple) {
    if ($apple->status !== \backend\models\Apple::STATUS_ON_TREE) continue; ?>
    <?= AppleWidget::widget(['apple' => $apple, 'shiftX' => 360, 'shiftY' => 150]) ?>
<?php } ?>
<div class="applet_tree">
    <img src="/img/tree.png" height="700" alt="Яблоня">
</div>
<div class="apples_on_ground">
    <?php
    foreach ($appleCollection as $apple) {
        if ($apple->status !== \backend\models\Apple::STATUS_ON_GROUND) continue ?>
        <?= AppleWidget::widget(['apple' => $apple, 'shiftX' => 360]) ?>
    <?php } ?>
</div>
<div class="apple_generate_container">
    <?= Html::a("Генерация новых яблок", ['apple-tree/generate'], ['class' => 'btn btn-lg btn-success']); ?>
</div>



