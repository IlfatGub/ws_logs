<?php

namespace app\modules\admin\models;

use Yii;

/**
 * Версия ОС
 */
class Processor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'processor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Версия ОС',
        ];
    }

    public static function getId($name){
        $query = self::find()->where(['name' => $name]);
        $count = $query->count();
        if($count > 0){
            $id = $query->one();
            return $id->id;
        }else{
            $new_depart = new self();
            $new_depart->name = $name;
            $new_depart->save();

            $id = $query->one();
            return $id->id;
        }
    }




}
