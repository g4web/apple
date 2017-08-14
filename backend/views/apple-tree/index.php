<?php
use backend\widgets\AppleWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->registerCssFile('/my/css/apple.css');
?>
<div>
    <?= Html::a("Генерация новых яблок", ['apple-tree/generate'], ['class' => 'btn btn-lg btn-primary']); ?>
</div>
<?php
/* @var backend\models\Apple $apple */
foreach ($appleCollection as $apple) {
    if ($apple->status !== \backend\models\Apple::STATUS_ON_TREE) continue; ?>
    <?= AppleWidget::widget(['apple' => $apple] )?>
<?php } ?>
<div>
    <img src="/img/tree.png" height="700" alt="">
</div>








