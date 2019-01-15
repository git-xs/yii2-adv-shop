<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 9:40
 */

namespace frontend\controllers;


use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $this->layout = "layouts1";
        return $this->render("index");
    }
}