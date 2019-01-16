<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 16:48
 */

namespace backend\modules\controllers;

use backend\modules\models\Admin;
use yii\web\Controller;
use Yii;

class PublicController extends Controller
{
    public function actionLogin()
    {
        $this->layout = false;

        $model = new Admin;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->login($post);
        }
        return $this->render("login",['model'=> $model]);
    }
}