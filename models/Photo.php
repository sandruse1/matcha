<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 05.09.17
 * Time: 13:17
 */

namespace app\models;
use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{
    public static function tableName(){
        return 'user';
    }

    public function attributeLabels(){
        return [
            'imageUpload' => ''
        ];
    }

    public function rules()
    {
        return [
            ['imageUpload', 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

}