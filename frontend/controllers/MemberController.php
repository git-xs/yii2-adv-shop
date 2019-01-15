<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/15
 * Time: 10:11
 */

namespace frontend\controllers;


use yii\web\Controller;

class MemberController extends Controller
{
    //用户注册登录
    public function actionAuth()
    {
        $this->layout = "layouts2";
        return $this->render("auth");
    }
}