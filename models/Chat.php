<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 12.09.17
 * Time: 16:02
 */

namespace app\models;


namespace app\models;

use yii\db\ActiveRecord;

class Chat extends ActiveRecord
{
    public static function tableName(){
        return 'chat';
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