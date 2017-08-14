<?php

namespace backend\services\apple;

use backend\models\Apple;

class Drop
{
    static public function fallById($id){
        $apple = Apple::findOne($id);

        if ($apple->status !== Apple::STATUS_ON_TREE) {
            throw new \Exception('Яблоко не на дереве');
        }

        $apple->status = Apple::STATUS_ON_GROUND;
        $apple->coordinate_y = 0;
        $apple->fall_date = date('Y-m-d H:i:s');
        $apple->save(false);
        return $apple;
    }
}