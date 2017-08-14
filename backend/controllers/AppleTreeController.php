<?php

namespace backend\controllers;

use \yii\web\Controller;
use backend\models\Apple;
use backend\models\AppleEaterGround;
use Yii;

class AppleTreeController extends Controller
{
    public function actionDrop()
    {
        $id = Yii::$app->request->post('id');
        $apple = Apple::findOne($id);
        $apple->fallToGround();
        if($apple->validate()){
            $apple->save(false);
        }
    }

    public function actionEat()
    {
        $post = Yii::$app->request->post('Apple');
        $appleRequest = Apple::findOne($post['id']);
        $appleRequest->load(Yii::$app->request->post(), 'Apple');
        $valid = $appleRequest->validate();
        $apple = Apple::findOne($post['id']);
        if($valid){
            $eater = new AppleEaterGround();
            $apple->eat($post['percent'],$eater);
            $apple->save(false);
        };

        return $this->renderAjax('eat',[
            'apple' => $appleRequest
        ]);
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
