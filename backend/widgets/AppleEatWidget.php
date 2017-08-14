<?php


namespace backend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class AppleEatWidget extends Widget
{
    /** @var \backend\models\Apple $apple **/
    public $apple;

    public function init()
    {
        parent::init();
        if ($this->apple === null) {
            throw new  \Exception('Не указанна форма');
        }
    }

    public function run()
    {
        $returnHtml = '';

        $form = ActiveForm::begin();
        $returnHtml .= '<form action="/apple/eat"  method="post">';
        $returnHtml .= $form->field($this->apple, 'id')->label(false)->hiddenInput(['id' => 'apple_'.$this->apple->id, 'class' => 'apple_id']);
        $returnHtml .= $form->field($this->apple, 'percent')->input('text');
        $returnHtml .= Html::button('Откусить', ['class' => 'btn', 'onclick' => 'appletree_eat($(this).parent(\'form\'))']);
        $returnHtml .= '</form>';
         ActiveForm::end();

        return $returnHtml;
    }

}