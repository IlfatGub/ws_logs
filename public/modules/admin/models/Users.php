<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id_user
 * @property string $login
 * @property string $fio
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'fio'], 'required'],
            [['login'], 'string', 'max' => 30],
            [[ 'phone'], 'string', 'max' => 255],
//            [['post'], 'string', 'max' => 255],
            [['depart'], 'string', 'max' => 500],
            [['login'], 'unique'],
            [['post', 'fio'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'login' => 'Login',
            'fio' => 'Fio',
            'post' => 'post',
        ];
    }

    public function comparisonPostName($id, $post, $name, $depart){
        $model = Users::findOne($id);
        $model->post = $post;
        $model->fio = $name;
        $model->depart = $depart;
        $model->save();
    }


    public function trim($text){
        return trim(preg_replace('|[\s]+|s', ' ', $text));
    }

    public function comparisonPostNameOne($login, $post, $name, $depart){

        $n = str_replace(' ', '_', $name);
        $apiData = json_decode(file_get_contents("http://tel.snhrs.ru/index.php/api/index?search=$n&fullfio=1"));
        if ($apiData->status){
            foreach ($apiData->data as $datum) {
                $phone = self::trim($datum->in);
                $phone .= self::trim($datum->out) ? '/'. self::trim($datum->out) : '';
                $post = self::trim($datum->dolzhnost);
                $depart = self::trim($datum->depart);
            }
        }else{
            $phone = null;
        }

//        echo "<pre>";
//        print_r(Dolzh::getId($post)); die();

        $model = Users::findOne(['login' => $login]);
        if(isset($model)){
            $model->post = Dolzh::getId($post) ? Dolzh::getId($post) : null;
            $model->fio =  Fio::getId($name);
            $model->depart =  (string)Depart::getId($depart);
            $model->post_text =   $post;
            $model->fio_text =    $name;
            $model->depart_text = $depart;
            $model->phone = $phone;
            $model->save();
        }else{
            $model = new Users();
            $model->post = Dolzh::getId($post) ? Dolzh::getId($post) : null;
            $model->fio =  Fio::getId($name);
            $model->depart =  (string)Depart::getId($depart);
            $model->post_text =   $post;
            $model->login =   $login;
            $model->fio_text =    $name;
            $model->depart_text = $depart;
            $model->phone = $phone;
            if($model->getSave($model)){
//                echo "<pre>";
//                print_r($model );
//                print_r($login ); die();
            }else{

            }
        }
    }


    //Вывод ошибки при сохранени
    public function getSave($model, $message = '1'){
        if($model->save()){
            Yii::$app->session->setFlash('error', $message);
        }else{
            $error = '';
            foreach ($model->errors as $key => $value) {
                $error .= '<br>'.$key.': '.$value[0];
            }
//            echo "<pre>";
//            print_r($error); die();
            Yii::$app->session->setFlash('error', 'Ошибка записи.'.$error);
        }
    }

//    public function getFullfio()
//    {
//        return $this->hasOne(Fio::className(),['id'=>'fio']);
//    }
//    public function getFulldepart()
//    {
//        return $this->hasOne(Depart::className(),['id'=>'depart']);
//    }
//    public function getFulldolzh()
//    {
//        return $this->hasOne(Dolzh::className(),['id_dolzh'=>'post']);
//    }

    public function getNameHost($id)
    {
        return Host::findOne($id)->host;
    }
    public function getIp($id)
    {
        return IpUser::findOne($id)->client_ip;
    }

    public function getIdFio($name){
        $login = str_replace("\\\\", "\\", $name);
        Users::Ldap($login);

        return Users::find()->where(['login' => $login])->one()->id_user;
    }

    public function Ldap($login){
        $lg = explode("\\", $login);
        if($lg[0] == 'SNHRS'){
            $srv = "10.224.177.30";
            $dn = "DC=snhrs,DC=ru";
            $srv_login = "www_ldap@snhrs.ru";
        }elseif($lg[0] == 'ZSMIK'){
            $srv = "10.224.200.1";
            $dn = "DC=zsmik,DC=com";
            $srv_login = "www_ldap@zsmik.com";
        }elseif($lg[0] == 'A-CONSALT'){
            $srv = "10.224.90.1";
            $srv_login = "www_ldap@a-consalt.ru";
            $dn = "DC=a-consalt,DC=ru";
        }elseif($lg[0] == 'NHRS'){
            $srv = "10.224.100.1";
            $dn = "DC=nhrs,DC=ru";
            $srv_login = "www_ldap@nhrs.ru";
        }

        $userLogin = $lg[1];

        $srv_password = "321qweR";
        $filter = "(&(objectCategory=user)(sAMAccountName=".$userLogin.")(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";
        $attr = array("cn","mail","title","department","description");

        $dc = ldap_connect($srv, 389);

        ldap_set_option($dc, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($dc, LDAP_OPT_REFERRALS, 0);

        if ($dc) {
            ldap_bind($dc,$srv_login,$srv_password);
            $result = ldap_search($dc,$dn,$filter,$attr);
            $result_entries = ldap_get_entries($dc,$result);
            ldap_unbind($dc);
        }

        $str = explode('OU', $result_entries[0]['dn']);
        $po = array("Завод строительных материалов и конструкций,", "Салаватнефтехимремстрой,");
        $replace = array(",", "=", "/", "\\", ".", "_");
        $s1 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[1]));
        $s2 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[2]));
        $s3 =  isset($str[3]) ? str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[3])): '';
        $s4 =  isset($str[4]) ?  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[4])) : '';
        $str = strlen($s4) > 0 ? $s4.', ' : '';
        $str.= strlen($s3) > 0 ? $s3.', ' : '';
        $str.= strlen($s2) > 0 ? $s2.', ' : '';
        $str.= strlen($s1) > 0 ? $s1.', ' : '';
        $depart = str_replace($po , "", substr($str, 0,-2));

        for ($i=0;$i<$result_entries['count'];$i++) {
            $post = isset($result_entries[$i]['description'][0]) ? $result_entries[$i]['description'][0] : '';
//            die();
            Users::comparisonPostNameOne($login, $post , $result_entries[$i]['cn'][0], $depart);
        }
    }
}
