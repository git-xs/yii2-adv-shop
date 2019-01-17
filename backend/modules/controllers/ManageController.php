<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/16
 * Time: 17:56
 */

namespace backend\modules\controllers;


use yii\web\Controller;
use Yii;
use backend\modules\models\Admin;
use yii\data\Pagination;

class ManageController extends Controller
{
    public function actionMailchangepass()
    {
        $this->layout = false;

        $time = Yii::$app->request->get("timestamp");
        $adminuser = Yii::$app->request->get("adminuser");
        $token = Yii::$app->request->get("token");

        $model = new Admin();
        $myToken = $model->createToken($adminuser,$time);
        //判断token是否一致
        if ($token != $myToken) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        //判断时间是否在5分钟之内
        if (time() - $time > 300) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }


        if (Yii::$app->request->isPost) {

            $post = Yii::$app->request->post();
            if ($model->changepass($post)) {
                Yii::$app->session->setFlash('info',"密码修改成功");
            }
        }

        $model->adminuser = $adminuser;
        return $this->render("mailchangepass",['model'=>$model]);
    }

    //列表展示
    public function actionManagers()
    {
        $this->layout = "layouts1";

        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render("managers",['managers'=>$managers,'pager'=> $pager]);
    }

    //添加管理员
    public function actionReg()
    {
        $this->layout = 'layouts1';

        $model = new Admin();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info','添加成功');
            }else {
                Yii::$app->session->setFlash('info','添加失败');
            }
        }

        return $this->render('reg',['model'=>$model]);
    }

}