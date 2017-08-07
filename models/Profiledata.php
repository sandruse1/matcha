<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 03.08.17
 * Time: 10:55
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\validators\EmailValidator;

class Profiledata extends ActiveRecord
{
    public $facebook;

    public static function tableName(){
        return 'user';
    }

    public function attributeLabels()
    {
        return [
        ];
    }

    public function rules()
    {
        return [
            [['user_avatar'], 'file'],
//            [ ['user_email', 'user_login', 'user_password'], 'required'],
//            [ ['user_login', 'user_password'], 'trim'],
//            [ 'user_password', 'string', 'min' => 8],
//            ['user_login', 'string' , 'length' => [8 , 16] ],
//            ['user_email', 'email'],
        ];
    }

}