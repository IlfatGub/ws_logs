<?php
namespace app\models;

use yii\db\ActiveRecord;

class Api extends ActiveRecord
{
    public static function tableName()
    {
        return 'userlog';
    }

}