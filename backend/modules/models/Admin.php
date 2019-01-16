<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/1/16
 * Time: 11:25
 */
namespace backend\modules\models;

use yii\db\ActiveRecord;

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
        ];
    }

    //登录
    public function login($data)
    {

    }
}