<?php
///**
// * Created by PhpStorm.
// * User: 01gig
// * Date: 22.09.2016
// * Time: 16:27
// */
use app\modules\admin\models\Users;
//
//$srv = "10.224.177.30";
//$srv_login = "user@snhrs.ru";
//$srv_password = "321qwe";
////$dn = "OU=АНТ-Консалт,OU=1C,OU=JSC_SNHRS_WORKS,DC=snhrs,DC=ru";
//$dn = "OU=Сектор информационных технологий,OU=Отдел безопасности информационных технологий и связи,OU=Центр планирования\\, методологии и работы с заказчиками,OU=СНХРС,OU=Салаватнефтехимремстрой,OU=JSC_SNHRS,DC=snhrs,DC=ru";
//$filter = "(&(objectCategory=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";
//$attr = array("cn","mail","title","department","company");
//
//$dc = ldap_connect('10.224.177.30', 389);
//
//ldap_set_option($dc, LDAP_OPT_PROTOCOL_VERSION, 3);
//ldap_set_option($dc, LDAP_OPT_REFERRALS, 0);
//
//if ($dc) {
//    ldap_bind($dc,$srv_login,$srv_password);
//    $result = ldap_search($dc,$dn,$filter,$attr);
//    $result_entries = ldap_get_entries($dc,$result);
//    ldap_unbind($dc);
//}
//?>
<!---->
<!---->
<!--<!--    -->--><?php
////    for ($i=0;$i<$result_entries['count'];$i++) {
////        foreach ($model as $item){
////            if(substr($result_entries[$i]['mail'][0], 0, -9) == substr($item->login, 6)){
////                if($result_entries[$i]['title'][0] <> $item->post){
////                    echo "Изменен ID:".$item->id_user."<br>";
////                    Users::comparisonPost($item->id_user, $result_entries[$i]['title'][0]);
////                }
////            }
////        }
////        ?>
<!--<!--    -->--><?php ////} ?>
<!---->
<!---->
<!--    <table border="1" cellpadding="5">-->
<!--        --><?php //for ($i=0;$i<$result_entries['count'];$i++) { ?>
<!--            <tr>-->
<!--                <td>--><?//=$result_entries[$i]['cn'][0]?><!--</td>-->
<!--                <td>--><?//=substr($result_entries[$i]['mail'][0], 0, -9) ?><!--</td>-->
<!--                <td>--><?//=$result_entries[$i]['title'][0]?><!--</td>-->
<!--            </tr>-->
<!--        --><?php //} ?>
<!--    </table>-->
<!--<br>-->
<!---->
<!--<table class="table table-bordered table-condensed table-responsive table-striped">-->
<!--    --><?php //foreach ($model as $item){ ?>
<!--    <tr>-->
<!--        <td>--><?//= substr($item->login, 6) ?><!--</td>-->
<!--        <td>--><?//= $item->post ?><!--</td>-->
<!--    </tr>-->
<!--    --><?php //} ?>
<!--</table>-->



<!--<table border="1" cellpadding="5">-->
<!---->
<?php //foreach ($model as $item){ ?>
<!---->
<!--    --><?php
//    $srv = "10.224.177.30";
//    $srv_login = "user@snhrs.ru";
//    $srv_password = "321qwe";
//    $dn = "DC=snhrs,DC=ru";
//    $filter = "(&(objectCategory=user)(sAMAccountName=".mb_strtolower(substr($item->login, 6)).")(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";
//    $attr = array("cn","mail","title","department","description");
//
//    $dc = ldap_connect('10.224.177.30', 389);
//
//    ldap_set_option($dc, LDAP_OPT_PROTOCOL_VERSION, 3);
//    ldap_set_option($dc, LDAP_OPT_REFERRALS, 0);
//
//    if ($dc) {
//        ldap_bind($dc,$srv_login,$srv_password);
//        $result = ldap_search($dc,$dn,$filter,$attr);
//        $result_entries = ldap_get_entries($dc,$result);
//        ldap_unbind($dc);
//    }
//
//        $str = explode('OU', $result_entries[0]['dn']);
////        print_r($str);
////        echo "<br>";
//        $po = array("Завод строительных материалов и конструкций,", "Салаватнефтехимремстрой,");
//        $replace = array(",", "=", "/", "\\", ".", "_");
//        $s1 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[1]));
//        $s2 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[2]));
//        $s3 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[3]));
//        $s4 =  str_replace($replace, "", preg_replace("/[a-zA-Z]/i", "", $str[4]));
//        $str = strlen($s4) > 0 ? $s4.', ' : '';
//        $str.= strlen($s3) > 0 ? $s3.', ' : '';
//        $str.= strlen($s2) > 0 ? $s2.', ' : '';
//        $str.= strlen($s1) > 0 ? $s1.', ' : '';
//        $depart = str_replace($po , "", substr($str, 0,-2));
////        echo $depart;
//
//    for ($i=0;$i<$result_entries['count'];$i++) {
//        if(($result_entries[$i]['description'][0] <> $item->post) or ($result_entries[$i]['cn'][0] <> $item->fio) or ($depart <> $item->depart) ){
//            echo "Изменен ID:".$item->id_user."<br>";
//            Users::comparisonPostName($item->id_user, $result_entries[$i]['description'][0], $result_entries[$i]['cn'][0], $depart);
//        }
//    }
//    ?>
<?php //} ?>