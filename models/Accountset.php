<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 03.09.17
 * Time: 13:01
 */

namespace app\models;

use yii\db\ActiveRecord;

class Accountset extends ActiveRecord
{
    public static function tableName(){
        return 'user';
    }

    public function attributeLabels()
    {
        return [
            'user_name' => 'Your name',
            'user_secondname' => 'Your surname',
            'user_sex' => 'Your gender',
            'user_about' => 'Something about you',
            'user_interest' => 'Your interests and hobbies',
            'user_orientation' => 'Your sexual orientation',
            'user_login' => 'Your login',
            'user_avatar' => 'Your cover photo',
            'user_day_of_birth' => 'Your date of birth',
            'user_phone' => 'Your phone number',
            'user_email' => 'Your email',
            'user_geolocation' => 'Your location',
        ];
    }

    public function rules()
    {
        return [
            [['user_avatar'], 'file', 'extensions'=>'jpg, gif, png','skipOnEmpty' => true ],
            [ ['user_name', 'user_secondname' , 'user_login',   'user_interest', 'user_about'], 'required'],
            [ ['user_name', 'user_secondname' , 'user_login',   'user_interest', 'user_phone', 'user_about'], 'trim'],
            [ ['user_name', 'user_secondname'] , 'string', 'length' => [2, 20]],
            ['user_login', 'string' , 'length' => [6 , 12] ],
            ['user_interest' , 'match', 'pattern' => '/^(#\w+(\s)?)+$/', 'message' => 'Something\'s wrong'],
//            ['user_day_of_birth', 'string' , 'length' => [10 , 10] ],
            ['user_phone' , 'match', 'pattern' => '/^\+38\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => 'Something\'s wrong'],
            [['user_about', 'user_interest'], 'string' , 'max' => 1000 ],
        ];
    }

}