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

        $model->adminpass = '';
        $model->repass = '';

        return $this->render('reg',['model'=>$model]);
    }

    //删除管理员
    public function actionDel()
    {
        $adminid = Yii::$app->request->get("adminid");
        if (empty($adminid)) {
            $this->redirect(['manage/managers']);
        }
        $model = new Admin();
        if ($model->deleteAll('adminid = :id', [':id'=> $adminid])) {
            Yii::$app->session->setFlash("info","删除成功");
            $this->redirect(['manage/managers']);
        }
    }

    //管理员 修改邮箱
    public function actionChangeemail()
    {
        $this->layout = 'layouts1';
        $model = Admin::find()->where('adminuser = :user',[':user' => Yii::$app->session['admin']['adminuser']])->one();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changeEmail($post)) {
                Yii::$app->session->setFlash("info","修改成功");
            }
            $this->adminpass = "";
        }
        return $this->render('changeemail',['model'=>$model]);
    }

    //管理员  修改密码
    public function actionChangepass()
    {
        $this->layout = "layouts1";
        $model = Admin::find()->where('adminuser = :user',[':user' => Yii::$app->session['admin']['adminuser']])->one();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changePass($post)) {
                Yii::$app->session->setFlash("info","修改成功");
            }
        }
        $model->adminpass = "";
        $model->repass = "";
        return $this->render('changepass',['model'=>$model]);

    }


}