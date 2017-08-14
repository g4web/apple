<?php

namespace backend\controllers;

use backend\services\apple\Delete as AppleDelete;
use backend\services\apple\GroundEater as AppleGroundEater;
use backend\services\apple\RandomGenerator as AppleRandomGenerator;
use \yii\web\Controller;
use backend\models\Apple;
use backend\services\apple\Drop as AppleDrop;
use Yii;
use yii\filters\AccessControl;

class AppleTreeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDrop()
    {
        $id = Yii::$app->request->post('id');
        $apple = AppleDrop::fallById($id);
        return $this->renderAjax('_appleAction',[
            'apple' => $apple
        ]);
    }

    public function actionEat()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['Apple']['id']) || !isset($post['Apple']['percent'])) {
            throw new \Exception('Не верный post запрос');
        }

        $apple = Apple::findOne($post['Apple']['id']);
        $percent = $post['Apple']['percent'];

        $appleEater = new AppleGroundEater($apple, $post);
        if($appleEater->eat($percent)){
            if($apple->percent === 0){
                AppleDelete::delete($apple);
                return 'done';
            }
        }

        return $this->renderAjax('_appleAction',[
            'apple' => $apple
        ]);

    }

    public function actionGenerate()
    {
        AppleRandomGenerator::generate(10,20);
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
