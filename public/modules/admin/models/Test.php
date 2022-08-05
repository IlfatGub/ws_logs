<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

class Test extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public function rules()
    {
        return [
            [['text'], 'string', 'max' => 1000],
        ];
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
