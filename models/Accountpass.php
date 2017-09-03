<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 03.09.17
 * Time: 13:02
 */

namespace app\models;


use yii\db\ActiveRecord;

class Accountpass extends ActiveRecord
{
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
            [ ['user_password', 'user_rep_password'] , 'string', 'min' => 8],
            ['user_rep_password', 'compare', 'compareAttribute' => 'user_password'],
        ];
    }

}