<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 9:41
 */

namespace frontend\controllers;


use yii\web\Controller;

class CartController extends Controller
{
    public function actionIndex()
    {
        $this->layout = "layouts2";
        return $this->render("index");
    }
}