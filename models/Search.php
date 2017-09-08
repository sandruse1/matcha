<?php
/**
 * Created by PhpStorm.
 * User: sandruse
 * Date: 06.09.17
 * Time: 14:00
 */

namespace app\models;
use yii\db\ActiveRecord;


class Search extends ActiveRecord
{
    public static function tableName(){
        return 'search';
    }

    public function attributeLabels()
    {
        return [
            'user_age_filter_checked' => 'By Age',
'user_rating_filter_checked' => 'By Rating',
            'user_sex' => '',
            'user_interest' => '',
            'user_orientation' => '',

        ];
    }

    public function rules()
    {
        return [
            ['user_interest' , 'match', 'pattern' => '/^(#\w+(\s)?)+$/', 'message' => 'Something\'s wrong'],

        ];
    }
}



