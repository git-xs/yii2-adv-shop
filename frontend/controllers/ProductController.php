<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 9:48
 */

namespace frontend\controllers;


use yii\web\Controller;

class ProductController extends Controller
{

    public function actionIndex()
    {
        $this->layout = "layouts2";
        return $this->render("index");
    }

    public function actionDetail()
    {
        $this->layout = "layouts2";
        return $this->render("detail");
    }
}