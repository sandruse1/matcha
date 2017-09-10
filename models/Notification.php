<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 10.09.17
 * Time: 16:20
 */

namespace app\models;

use yii\db\ActiveRecord;

class Notification extends ActiveRecord
{
    public static function tableName(){
        return 'notification';
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