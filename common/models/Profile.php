<?php
/**
 * Created by PhpStorm.
 * User: xs
 * Date: 2019/2/7
 * Time: 15:42
 */

namespace common\models;


use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%profile}}";
    }
}