<?php


namespace backend\widgets\apple;

use yii\base\Widget;
use backend\models\Apple;

class AppleWidget extends Widget
{
    /** @var Apple $apple * */
    public $apple;

    public $shiftX = 0;

    public $shiftY = 0;

    public function init()
    {
        parent::init();
        if ($this->apple === null || !$this->apple instanceof Apple) {
            throw new  \Exception('Не указанна модель яблок');
        }
    }

    public function run()
    {
        $returnHtml = '';
        $style = 'margin-left: ' . ($this->apple->coordinate_x + $this->shiftX) . 'px;
                  margin-top: ' . ($this->apple->coordinate_y == 0 ? $this->apple->coordinate_y : $this->apple->coordinate_y + $this->shiftY) . 'px;';
        $returnHtml .= '<span class="dropdown  dropup apple_position" id="apple_' . $this->apple->id . '" style="' . $style . '">';
            $returnHtml .= '<a class="dropdown-toggle" data-toggle="dropdown">';
                $returnHtml .= '<span class="apple"  style="background-color: #' . $this->apple->color . '">';
                    $returnHtml .= '<b class="caret"></b>';
                $returnHtml .= '</span>';
            $returnHtml .= '</a>';
            $returnHtml .= '<ul class="dropdown-menu" role="menu">';
                $returnHtml .= AppleActionWidget::widget(['apple' => $this->apple]);
            $returnHtml .= '</ul>';
        $returnHtml .= '</span>';
        return $returnHtml;
    }

}