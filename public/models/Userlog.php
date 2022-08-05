<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userlog".
 *
 * @property integer $id
 * @property string $date_srv
 * @property string $datehost
 * @property integer $id_host
 * @property string $host2
 * @property string $server
 * @property integer $id_user
 * @property string $user2
 * @property integer $id_ip
 * @property string $client_ip2
 * @property integer $adm
 * @property string $clName
 * @property string $id_IPAdrs
 * @property string $id_MACAdrs
 * @property integer $id_dn
 * @property integer $id_dolzh
 */
class Userlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_srv', 'datehost', 'host2', 'server', 'user2', 'client_ip2'], 'required'],
            [['date_srv', 'datehost'], 'safe'],
            [['id_host', 'id_user', 'id_ip', 'adm', 'id_dn', 'id_dolzh', 'id_mac'], 'integer'],
            [['host2'], 'string', 'max' => 20],
            [['server'], 'string', 'max' => 10],
            [['user2', 'client_ip2', 'id_IPAdrs', 'id_MACAdrs'], 'string', 'max' => 30],
            [['clName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_srv' => 'Date Srv',
            'datehost' => 'Datehost',
            'id_host' => 'Id Host',
            'host2' => 'Host2',
            'server' => 'Server',
            'id_user' => 'Id User',
            'id_mac' => 'id_mac',
            'user2' => 'User2',
            'id_ip' => 'Id Ip',
            'client_ip2' => 'Client Ip2',
            'adm' => 'Adm',
            'clName' => 'Cl Name',
            'id_IPAdrs' => 'Id  Ipadrs',
            'id_MACAdrs' => 'Id  Macadrs',
            'id_dn' => 'Id Dn',
            'id_dolzh' => 'Id Dolzh',
        ];
    }
}
