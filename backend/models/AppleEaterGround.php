<?php


namespace backend\models;

class AppleEaterGround implements AppleEaterInterface
{
    protected $apple;
    protected $rottedTime;

    public function __construct($rottedTime = 5 * 60 * 60)
    {
        $this->rottedTime = $rottedTime;
    }

    public function checkEating(Apple $apple)
    {
        $this->apple = $apple;

        if ($this->apple->status !== Apple::STATUS_ON_GROUND) {
            throw new \Exception("Я не могу есть яблоки не на земле" );
        }

        $rottedDate = strtotime($this->apple->fall_date) + $this->rottedTime;
        if ($this->apple->status === Apple::STATUS_ON_GROUND && $rottedDate < time()) {
            throw new \Exception("Я не могу есть гнилые яблоки" );
        }
    }
}