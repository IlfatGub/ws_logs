<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "dolzh".
 *
 * @property integer $id_dolzh
 * @property string $dolzhnost
 */
class Dolzh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dolzh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dolzhnost'], 'required'],
            [['dolzhnost'], 'string', 'max' => 255],
            [['dolzhnost'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dolzh' => 'Id Dolzh',
            'dolzhnost' => 'Dolzhnost',
        ];
    }

    public static function getId($var){
        $query = Dolzh::find()->where(['dolzhnost' => $var]);
        $count = $query->count();
        if($count > 0){
            $id = $query->one();
            return $id->id_dolzh;
        }else{
            $new_depart = new Dolzh();
            $new_depart->dolzhnost = $var;
            $new_depart->save();

            $id = $query->one();
            return $id->id_dolzh;
        }
    }

}
