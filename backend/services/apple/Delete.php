<?php


namespace backend\services\apple;


use backend\models\Apple;

class Delete
{
    public static function delete(Apple $apple)
    {
        if ($apple->percent > 0) {
            throw new \Exception("Яблоко еще недоедено");
        }
        $apple->status = Apple::STATUS_DELETED;
        $apple->save();
    }
}