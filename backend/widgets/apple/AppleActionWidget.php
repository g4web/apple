<?php


namespace backend\widgets\apple;

use backend\models\Apple;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class AppleActionWidget extends Widget
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
        if($this->apple->status == Apple::STATUS_ON_TREE){
            $returnHtml .= '<li><input type="button" class="btn" onclick="apple_drop('. $this->apple->id .')" value="Сбросить"></li>';
        }
        if($this->apple->status == Apple::STATUS_ON_GROUND) {
            $returnHtml .= '<li>';
                $form = ActiveForm::begin();
                $returnHtml .= '<form action="/apple/eat"  method="post">';
                $returnHtml .= $form->field($this->apple, 'id')->label(false)->hiddenInput(['id' => 'apple_'.$this->apple->id, 'class' => 'apple_id']);
                $returnHtml .= $form->field($this->apple, 'percent')->input('text');
                $returnHtml .= Html::button('Откусить', ['class' => 'btn', 'onclick' => 'apple_eat($(this).parent(\'form\'))']);
                $returnHtml .= '</form>';
                 ActiveForm::end();
            $returnHtml .= '</li>';
        }
        return $returnHtml;
    }
}