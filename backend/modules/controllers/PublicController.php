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

    //登录
    public function actionLogin()
    {
        $this->layout = false;

        $model = new Admin;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->render("login",['model'=> $model]);
    }

    //退出
    public function actionLogout()
    {
        Yii::$app->session->removeAll();
        if (!isset(Yii::$app->session['admin']['isLogin'])) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }

    //找回密码
    public function actionSeekPassword()
    {
        $this->layout = false;

        $model = new Admin();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->seekPass($post)) {
                $data = $model->seekPass($post);
                $response = $this->sendEmail($data['useremail'],"管理员找回密码",$data['content']);
                if ($response) {
                    Yii::$app->session->setFlash('info',"邮箱发送成功");
                }
            }
        }
        return $this->render("seekpassword",[
            'model' => $model
        ]);
    }

    //发送邮件
    public function sendEmail($email,$subject,$body)
    {
        $mailer = Yii::$app->mailer->compose();
        $mailer->setTo($email);
        $mailer->setSubject($subject);
        $mailer->setHtmlBody($body);
        $status = $mailer->send();
        return $status;
    }

}