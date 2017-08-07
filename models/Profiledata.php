<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 03.08.17
 * Time: 10:55
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\validators\FileValidator;
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
            'user_name' => 'Your name',
            'user_secondname' => 'Your surname',
            'user_sex' => 'Your gender',
            'user_about' => 'Write something about yourself',
            'user_interest' => 'Your interests and hobbies',
            'user_orientation' => 'Your sexual orientation',
            'user_login' => 'Your login',
            'user_avatar' => 'Your cover photo',
            'user_day_of_birth' => 'Your date of birth',
            'user_phone' => 'Your phone number',
            'user_password' => 'Your login password',
            'user_rep_password' => 'Repeat your login password',
        ];
    }

    public function rules()
    {
        return [
            [['user_avatar'], 'file', 'extensions'=>'jpg, gif, png', 'skipOnEmpty'=>false],
            [ ['user_name', 'user_secondname' , 'user_login', 'user_password', 'user_rep_password', 'user_avatar', 'user_day_of_birth', 'user_interest', 'user_about'], 'required'],
            [ ['user_name', 'user_secondname' , 'user_login', 'user_password', 'user_rep_password', 'user_avatar', 'user_day_of_birth', 'user_interest', 'user_phone', 'user_about'], 'trim'],
            [ ['user_name', 'user_secondname'] , 'string', 'length' => [2, 20]],
            [ ['user_password', 'user_rep_password'] , 'string', 'min' => 8],
            ['user_rep_password', 'compare', 'compareAttribute' => 'user_password'],
            ['user_login', 'string' , 'length' => [6 , 12] ],
            ['user_day_of_birth', 'string' , 'length' => [10 , 10] ],
            ['user_phone' , 'match', 'pattern' => '/^\+38\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => 'Something\'s wrong'],
            [['user_about', 'user_interest'], 'string' , 'max' => 1000 ],
        ];
    }

}
