<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/16
 * Time: 11:25
 */
namespace backend\modules\models;

use yii\db\ActiveRecord;
use Yii;

class Admin extends ActiveRecord
{

    //生成库中不存在的变量
    public $rememberMe = true;

    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function rules()
    {
        return [
            ['adminuser','required','message'=>'管理员账号不能为空'],
            ['adminpass','required','message'=>'管理员密码不能为空'],
            ['rememberMe','boolean'],
            ['adminpass','validatePass'],
        ];
    }

    //密码验证
    public function validatePass()
    {
        //如果之前不存在错误
        if (!$this->hasErrors()) {
            $data = self::find()->where('adminuser = :user and adminpass = :pass',[':user' => $this->adminuser,":pass" => md5($this->adminpass)])->one();
            if (is_null($data)) {
                $this->addError("adminpass","用户名或者密码错误");
            }
        }
    }

    //登录
    public function login($data)
    {
        if ($this->load($data) && $this->validate()) {
            //验证成功,将用户信息写入session
            $lifetime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            //设置保存session的cookie的有效期
            session_set_cookie_params($lifetime);
            $session['admin'] = [
                'adminuser' => $this->adminuser,
                'isLogin' => 1,
            ];
            //更新登录时间和登录IP
            $this->updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIP)],'adminuser = :user',[':user'=>$this->adminuser]);
            //(bool)为将变量强转为boolean型
            return (bool)$session['admin']['isLogin'];
        }
        return false;
    }
}