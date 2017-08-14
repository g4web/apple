<?php

namespace backend\controllers;

use \yii\web\Controller;
use backend\models\Apple;

class AppleTreeController extends Controller
{
    public function actionDrop()
    {
    }

    public function actionEat()
    {
    }

    public function actionGenerate()
    {
        Apple::deleteAll();
        $appleCount = rand(5, 25);
        for ($i = 0; $i <= $appleCount; $i++) {
            $new = new Apple();
            $new->save(false);
        }
        $this->redirect('index');
    }

    public function actionIndex()
    {
        $appleCollection = Apple::find()->all();
        return $this->render('index',[
            'appleCollection' => $appleCollection
        ]);
    }

}
