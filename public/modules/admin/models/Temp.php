<?php

namespace app\modules\admin\models;

use Yii;

/**
 * Версия ОС
 *
 * @property int $count
 * @property int $type
 * @property string $ip
 */


class Temp extends \yii\db\ActiveRecord
{

    public $_ip;
    const QUERY_PC = 1;
    const QUERY_PC_SRV = 2;
    const QUERY_SRV = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['ip'], 'required'],
            [['ip'], 'string', 'max' => 255],
            [['count', 'type'], 'integer'],
            [['ip'], 'unique'],
        ];
    }




    public function __construct()
    {
        $this->_ip = '1';
        parent::__construct();
    }


    public function firstConnect(){
        if(!self::find()->where(['ip' =>  $_SERVER['REMOTE_ADDR']])->exists()){
            $model = new self();
            $model->count = 50;
            $model->type = 1;
            $model->ip =  $_SERVER['REMOTE_ADDR'];
            $model->save();
        }
    }


    public static function getCount(){
        if(self::find()->where(['ip' =>  $_SERVER['REMOTE_ADDR']])->exists()){
            $ip = self::find()->where(['ip' =>  $_SERVER['REMOTE_ADDR']])->one();
            return $ip->count;
        }
        return false;
    }

    public static function getType(){
        if(self::find()->where(['ip' =>  $_SERVER['REMOTE_ADDR']])->exists()){
            $ip = self::find()->where(['ip' =>  $_SERVER['REMOTE_ADDR']])->one();
            return $ip->type;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'name' => 'Версия ОС',
        ];
    }


}
