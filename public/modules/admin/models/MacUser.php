<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "mac_user".
 *
 * @property integer $id_mac
 * @property string $client_mac
 */
class MacUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mac_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_mac'], 'required'],
            [['client_mac'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_mac' => 'Id Mac',
            'client_mac' => 'Client Mac',
        ];
    }

    public function getMac($id)
    {
        return MacUser::findOne($id);
    }

    /*
     * Получаем АйДи АйПи
     */
    public function getIdMac($mac){
        $mac_once = explode(" ", $mac);
        $count = MacUser::find()->where(['client_mac' => $mac_once[0]])->count();
        if($count > 0){
            $id = MacUser::find()->where(['client_mac' => $mac_once[0]])->one();
            return $id->id_mac;
        }else{
            $new_ip = new MacUser();
            $new_ip->client_mac =  $mac_once[0];
            $new_ip->save();

            $id = MacUser::find()->where(['client_mac' => $mac_once[0]])->one();
            return $id->id_mac;
        }
    }

    /*
     * Получаем массив АйДи АйПи
     */
    public function getMassivIdMac($mac){
        $mac_once = explode(" ", $mac);
        $massiv = '';
        for ($i=0; $i<count($mac_once); $i++) {
            $massiv .= ' '.MacUser::getIdMAC($mac_once[$i]);
        }
        return $massiv;
    }

}
