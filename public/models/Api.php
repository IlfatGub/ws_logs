<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\modules\admin\models\Host;
use app\modules\admin\models\Users;
use app\modules\admin\models\IpUser;
use app\modules\admin\models\MacUser;
use app\modules\admin\models\Dolzh;

class Api extends ActiveRecord
{
    const SCENARIO_INDEX = 'index';

    public $id_user_fio;
    public $search;


    public function rules()
    {
        return [
            [['id_fio'], 'required'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['index'] = ['id_fio'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'userlog';
    }



    public function afterFind()
    {
        $this->datehost = $this->getDateTime($this->datehost);
//        $this->users->login = mb_substr($this->users->login, 6);
        $this->id_MACAdrs = $this->getClientMac($this->id_MACAdrs);
        $this->id_host = '321';
    }


    public function getClientMac($id)
    {
        return MacUser::findOne($id)->client_mac;
    }

    public function getIp()
    {
        return $this->hasOne(IpUser::className(), ['id_ip' => 'id_ip']);
    }

    public function getMac()
    {
        return $this->hasOne(MacUser::className(), ['id_mac' => 'id_MACAdrs']);
    }

    public function getHost()
    {
        return $this->hasOne(Host::className(), ['id_host' => 'id_host']);
    }

    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }

    public function getUserName()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }

    public function getDolzh()
    {
        return $this->hasOne(Dolzh::className(), ['id_dolzh' => 'id_dolzh']);
    }

    public function getDateTime($date)
    {
        $str = new \DateTime($date);


        $datetime1 = new \DateTime(date('Y-m-d'));
        $datetime2 = new \DateTime($str->format('Y-m-d'));
        $interval = $datetime1->diff($datetime2);
        if ($interval->format('%a') == 0) {
            return $str->format('Сегодня H:i');
        } elseif ($interval->format('%a') == 1) {
            return $str->format('Вчера H:i');
        }

        return $str->format('Y/m/d H:i');
    }

}
