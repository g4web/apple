<?php


namespace backend\services\apple;

use backend\models\Apple;

class GroundEater
{
    const ROTTED_TIME = 5 * 60 * 60;

    protected $apple;
    protected $post;

    public function __construct(Apple $apple, $post)
    {
        $this->apple = $apple;
        $this->post = $post;
    }

    public function eat($percent)
    {
        $valid = $this->validate($percent);
        if ($valid) {
            $this->apple->percent -= $percent;
            $this->apple->save(false);
            return true;
        }
        return false;
    }

    public function validate($percent)
    {
        $isValidTotal = $this->_defaultValidate() * $this->_groundStatusValidate() * $this->_groundPercentValidate($percent);
        return $isValidTotal;
    }

    protected function _defaultValidate()
    {
        $tempApple = new Apple();
        $tempApple->load($this->post, 'Apple');
        $isValid = $tempApple->validate();
        $errors = $tempApple->getErrors();
        foreach ($errors as $attribute => $attributeErrors) {
            foreach ($attributeErrors as $attributeError) {
                $this->apple->addError($attribute, $attributeError);
            }
        }
        return $isValid;
    }

    protected function _groundStatusValidate()
    {
        if ($this->apple->status !== Apple::STATUS_ON_GROUND) {
            $this->apple->addError('percent', "Я не могу есть яблоки не на земле");
            return false;
        }

        $rottedDate = strtotime($this->apple->fall_date) + self::ROTTED_TIME;
        if ($this->apple->status === Apple::STATUS_ON_GROUND && $rottedDate < time()) {
            $this->apple->addError('percent', "Я не могу есть гнилые яблоки");
            return false;
        }

        return true;
    }

    protected function _groundPercentValidate($percent)
    {
        if ($this->apple->percent < $percent) {
            $this->apple->addError('percent', "Нельзя съесть $percent % яблока, осталось только " . $this->apple->percent . " %");
            return false;
        }

        if ($this->apple->percent <= 0 || $this->apple->status === Apple::STATUS_DELETED) {
            $this->apple->addError('percent', "От яблока ничего не осталось");
            return false;
        }
        return true;
    }
}