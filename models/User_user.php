<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 09.09.17
 * Time: 14:50
 */

namespace app\models;
use yii\db\ActiveRecord;


class User_user extends ActiveRecord
{
    public static function tableName(){
        return 'user_user';
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    public function rules()
    {
        return [

        ];
    }
}