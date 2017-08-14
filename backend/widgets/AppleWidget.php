<?php


namespace backend\widgets;

use yii\base\Widget;
use backend\models\Apple;

class AppleWidget extends Widget
{
    /** @var Apple $apple **/
    public $apple;

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
        $style = 'margin-left: '. ($this->apple->coordinate_x + 100) .'px;
                  margin-top: '. ($this->apple->coordinate_y == 0 ? $this->apple->coordinate_y - 30 : $this->apple->coordinate_y + 170) .'px;';
        $returnHtml .= '<span class="dropdown apple_position" id="apple_'. $this->apple->id .'" style="'.$style.'">';
            $returnHtml .= '<a class="dropdown-toggle" data-toggle="dropdown">';
                $returnHtml .= '<span class="apple"  style="background-color: #'. $this->apple->color .'">';
                $returnHtml .= '<b class="caret"></b>';
                $returnHtml .= '<span>'.$this->apple->getSize().'</span>';
            $returnHtml .= '</a>';
            $returnHtml .= '<ul class="dropdown-menu" role="menu"> test';
            $returnHtml .= '</ul>';
        $returnHtml .= '</span>';

        return $returnHtml;
    }

}