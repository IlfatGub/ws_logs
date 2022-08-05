<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "ip_user".
 *
 * @property integer $id_ip
 * @property string $client_ip
 */
class IpUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ip_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_ip'], 'required'],
            [['client_ip'], 'string', 'max' => 30],
            [['client_ip'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ip' => 'Id Ip',
            'client_ip' => 'Client Ip',
        ];
    }

    /*
     * Получаем АйДи АйПи
     */
    public function getIdIp($ip){
        $ip_once = explode(" ", $ip);
        $count = IpUser::find()->where(['client_ip' => $ip_once[0]])->count();
        if($count > 0){
            $id = IpUser::find()->where(['client_ip' => $ip_once[0]])->one();
            return $id->id_ip;
        }else{
            $new_ip = new IpUser();
            $new_ip->client_ip =  $ip_once[0];
            $new_ip->save();

            $id = IpUser::find()->where(['client_ip' => $ip_once[0]])->one();
            return $id->id_ip;
        }
    }

    /*
     * Получаем массив АйДи АйПи
     */
    public function getMassivIdIp($ip){
        $ip_once = explode(" ", $ip);
        $massiv = '';
        for ($i=0; $i<count($ip_once); $i++) {
            $massiv .= ' '.IpUser::getIdIp($ip_once[$i]);
        }
        return $massiv;
    }
}
