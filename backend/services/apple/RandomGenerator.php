<?php


namespace backend\services\apple;


use backend\models\Apple;

class RandomGenerator
{
    public static function generate($minCount, $maxCount){
        Apple::deleteAll();
        $appleCount = rand($minCount, $maxCount);
        for ($i = 0; $i <= $appleCount; $i++) {
            $new = new Apple();
            $new->save(false);
        }
    }

}