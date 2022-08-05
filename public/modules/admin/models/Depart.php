<?php

namespace app\modules\admin\models;

use Yii;

class Depart extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'depart';
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => 'Отдел',
        ];
    }

    /*
     * вывод АйДи Отдела
     */
    public function getId($var){
        $query = Depart::find()->where(['name' => $var]);
        $count = $query->count();
        if($count > 0){
           $id = $query->one();
           return $id->id;
        }else{
            $new_depart = new Depart();
            $new_depart->name = $var;
            $new_depart->save();

            $id = $query->one();
            return $id->id;
        }
    }
}
