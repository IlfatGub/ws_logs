<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

class Userlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $id_user_fio;
    public $search;
    public $_datehost;

    public static function tableName()
    {
        return 'userlog';
    }

//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return [
//            [['id_host', 'id_user', 'id_ip', 'adm', 'id_dn', 'id_dolzh', 'id_user_fio'], 'integer'],
//        ];
//    }

//    /**
//     * @inheritdoc
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'date_srv' => 'Date Srv',
//            'datehost' => 'Время входа',
//            'id_host' => 'Имя компьютера',
//            'host2' => 'Host2',
//            'server' => 'Server',
//            'id_user' => 'Логин',
//            'user2' => 'User2',
//            'id_ip' => 'Ip address',
//            'client_ip2' => 'Client Ip2',
//            'adm' => 'Adm',
//            'clName' => 'Cl Name',
//            'id_IPAdrs' => 'Id  Ipadrs',
//            'id_MACAdrs' => 'Id  Macadrs',
//            'id_dn' => 'Id Dn',
//            'id_dolzh' => 'Id Dolzh',
//            'id_user_fio' => 'ФИО',
//            'id_user_post' => 'Должность',
//            'search' => 'Поиск',
//        ];
//    }
//

    public function afterFind()
    {
        $this->_datehost = $this->datehost;
        $this->datehost = $this->getDateTime($this->datehost);
//        $this->users->login = mb_substr($this->users->login, 6);
//        $this->id_MACAdrs = $this->getClientMac($this->id_MACAdrs);
    }


//    public function getClientMac($id){
//        return MacUser::findOne($id)->client_mac;
//    }

    public function getIp()
    {
        return $this->hasOne(IpUser::className(),['id_ip'=>'id_ip']);
    }
    public function getMac()
    {
        return $this->hasOne(MacUser::className(),['id_mac'=>'id_mac']);
    }
    public function getHost()
    {
        return $this->hasOne(Host::className(),['id_host'=>'id_host']);
    }
    public function getUsers()
    {
        return $this->hasOne(Users::className(),['id_user'=>'id_user']);
    }
//    public function getUserName()
//    {
//        return $this->hasOne(Users::className(),['id_user'=>'id_user']);
//    }
//    public function getDolzh()
//    {
//        return $this->hasOne(Dolzh::className(),['id_dolzh'=>'id_dolzh']);
//    }
    public function getOs()
    {
        return $this->hasOne(OsVersion::className(),['id'=>'id_osversion']);
    }
//    public function getSysmodel()
//    {
//        return $this->hasOne(Sysmodel::className(),['id'=>'id_sysmodel']);
//    }
//    public function getBios()
//    {
//        return $this->hasOne(Bios::className(),['id'=>'id_bios']);
//    }
    public function getProcessor()
    {
        return $this->hasOne(Processor::className(),['id'=>'id_processor']);
    }
//    public function getVideocard()
//    {
//        return $this->hasOne(Videocard::className(),['id'=>'id_videocard']);
//    }

    public function getDateTime($date){
        $str = new \DateTime($date);
        $datetime1 = new \DateTime(date('Y-m-d'));
        $datetime2 = new \DateTime($str->format('Y-m-d'));
        $interval = $datetime1->diff($datetime2);
        if($interval->format('%a') == 0){
            return $str->format('Сегодня H:i');
        }elseif ($interval->format('%a') == 1){
            return $str->format('Вчера H:i');
        }

        return $str->format('Y/m/d H:i');
    }
//
//    public function deleteUserlog($id){
//        Userlog::findOne($id)->delete();
//    }
//
//    public function clearUserlog(){
//        $date = date('m-d h:i:s');
//        $y =  date('Y') - 1;
//        $model = Userlog::find()->select('id')->andFilterWhere(['<', 'datehost', $y.'-'.$date])->orderBy(['datehost' => SORT_ASC])->limit(1000)->all();
//        foreach ($model as $item){
//            Userlog::findOne($item->id)->delete();
//        }
//        unset($model);unset($item);
//    }
}
