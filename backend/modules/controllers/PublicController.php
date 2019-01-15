<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 16:48
 */

namespace backend\modules\controllers;


use yii\web\Controller;

class PublicController extends Controller
{
    public function actionLogin()
    {
        $this->layout = false;
        return $this->render("login");
    }
}