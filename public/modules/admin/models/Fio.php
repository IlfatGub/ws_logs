<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

class Fio extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'fio';
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
            'Name' => 'ФИО',
        ];
    }

    public function getId($var){
        $query = Fio::find()->where(['name' => $var]);
        $count = $query->count();
        if($count > 0){
            $id = $query->one();
            return $id->id;
        }else{
            $new_depart = new Fio();
            $new_depart->name = $var;
            $new_depart->save();

            $id = $query->one();
            return $id->id;
        }
    }

//    public function fio(){
//        $model = Users::find()->andWhere(['>', 'id_user' , 1500 ])->all();
//        foreach ($model as $item) {
//            $upd = Users::findOne($item->id_user);
//            $upd->post = (string)Dolzh::getId($item->post);
//            $upd->fio =  (string)Fio::getId($item->fio);
//            $upd->depart =  (string)Depart::getId($item->depart);
//            $upd->save();
//        }
//    }

}
