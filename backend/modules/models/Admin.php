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
    public $repass;

    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function rules()
    {
        return [
            ['adminuser','required','message'=>'管理员账号不能为空','on'=>['login','seekpass','changepass']],
            ['adminpass','required','message'=>'管理员密码不能为空','on'=>['login','changepass']],
            ['rememberMe','boolean','on'=>['login']],
            ['adminpass','validatePass','on'=>['login']],
            ['adminemail','required','message'=>'电子邮箱不能为空','on'=>['seekpass']],
            ['adminemail','email','message'=>'电子有限格式不正确','on'=>['seekpass']],
            ['adminemail','validateEmail','on'=>['seekpass']],
            ['repass','required','message'=>'确认密码不能为空','on'=>['changepass']],
            ['repass','compare','compareAttribute'=>'adminpass','message'=>'两次密码不一致','on'=>['changepass']],
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

    //邮箱验证
    public function validateEmail()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where('adminuser = :user and adminemail = :email',[':user'=>$this->adminuser,':email'=>$this->adminemail])->one();
            if (is_null($data)) {
                $this->addError("adminemail","管理员邮箱不匹配");
            }
        }
    }

    //登录
    public function login($data)
    {
        $this->scenario = "login";
        if ($this->load($data) && $this->validate()) {
            //验证成功,将用户信息写入session
            $lifetime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            //设置保存session的cookie的有效期
            Yii::$app->session->setCookieParams(['lifetime'=>$lifetime]);
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

    //找回密码
    public function seekPass($data)
    {
        $this->scenario = "seekpass";
        if ($this->load($data) && $this->validate()) {
            //验证成功
            $time = time();
            $token = $this->createToken($this->adminuser,$time);
            $content = Yii::$app->request->getHostInfo() . "/index.php?r=admin/manage/mailchangepass&timestamp=" . $time . "&adminuser=" . $this->adminuser . "&token=" . $token;
            $content = "<a href=".$content.">点击更改管理员密码</a>";
            return [
                'useremail' => $this->adminemail,
                'content' => $content,
            ];
        }
        return false;
    }

    //生成token
    public function createToken($adminuser,$time)
    {
        $token = md5(md5($adminuser,$time));
        return $token;
    }

    //修改密码
    public function changePass($data)
    {
        $this->scenario = "changepass";
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['adminpass' => md5($this->adminpass)],'adminuser = :user',[':user' => $this->adminuser]);
        }
        return false;
    }

}