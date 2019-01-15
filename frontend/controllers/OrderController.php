<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 10:01
 */

namespace frontend\controllers;


use yii\web\Controller;

class OrderController extends Controller
{
    //商场收银台页面搭建
    public function actionCheck()
    {
        $this->layout = "layouts2";
        return $this->render("check");
    }

    //商场用户订单中心页面
    public function actionIndex()
    {
        $this->layout = "layouts2";
        return $this->render("index");
    }
}