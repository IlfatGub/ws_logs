<?php

$link = @mysqli_connect('localhost','root','armagedon','logs');@mysqli_query($link, "SET NAMES 'utf8'");
@mysqli_query($link, "SET collation_connection='utf8_ci'");
@mysqli_query($link, "SET collation_server='utf8_ci'");
@mysqli_query($link, "SET character_set_client='utf8'");
@mysqli_query($link, "SET character_set_connection='utf8'");
@mysqli_query($link, "SET character_set_results='utf8'");
@mysqli_query($link, "SET character_set_server='utf8'");
$secretpass = 'h5mr!-Sk+kFc(S4FtI%,v';


if( !empty($_POST['dtime']) and !empty($_POST['host']) and !empty($_POST['user']) )
{
    $dtime = $_POST['dtime'];	unset($_POST['dtime']);
    $host = $_POST['host'];		unset($_POST['host']);
    $user = $_POST['user'];		unset($_POST['user']);
    $clName = ($_POST['clName'] == '%CLIENTNAME%') ? '' : $_POST['clName']; unset($_POST['clName']);
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $IPAdrs = $_POST['IPAdrs'];		unset($_POST['IPAdrs']);
    $MACAdrs = $_POST['MACAdrs'];	unset($_POST['MACAdrs']);
    $adm = $_POST['adm']; unset($_POST['adm']);
//    include 'con_db.php';
//    include 'fun_ld.php';

    $IPAdrs = explode(" ", $IPAdrs);
    $MACAdrs = explode(" ", $MACAdrs);

    for ($i=0; $i<count($MACAdrs); $i++) {
        $cnt = mysqli_query($link, "SELECT count(*),id_mac FROM mac_user WHERE client_mac = '".$MACAdrs[$i]."' LIMIT 1") or die(mysqli_error());

        $resCnt = mysqli_fetch_row($cnt);
        $id_mac = $resCnt[1];
        if ($resCnt[0] == 0)
        {
            mysqli_query($link, "INSERT INTO mac_user (client_mac) VALUES ('$MACAdrs[$i]')") or die(mysqli_error());
            $id_mac = mysqli_insert_id($link);
        }
        if (($i+1) == count($MACAdrs))
        {
            $id_MACAdrs .= (string)$id_mac;
        }
        else
        {
            $id_MACAdrs .= (string)$id_mac." ";
        }
    }
    $mac_once = explode(" ", $id_MACAdrs);

    for ($i=0; $i<count($IPAdrs); $i++) {
        $cnt = mysqli_query($link, "SELECT count(*),id_ip FROM ip_user WHERE client_ip = '".$IPAdrs[$i]."' LIMIT 1") or die(mysqli_error());
        $resCnt = mysqli_fetch_row($cnt);
        $id_ip = $resCnt[1];
        if ($resCnt[0] == 0)
        {
            mysqli_query($link, "INSERT INTO ip_user (client_ip) VALUES ('$IPAdrs[$i]')") or die(mysqli_error());
            $id_ip = mysqli_insert_id($link);
        }
        if (($i+1) == count($IPAdrs))
        {
            $id_IPAdrs .= (string)$id_ip;
        }
        else
        {
            $id_IPAdrs .= (string)$id_ip." ";
        }
    }
    $cnt = mysqli_query($link, "SELECT count(*),id_ip FROM ip_user WHERE client_ip = '".$client_ip."' LIMIT 1") or die(mysqli_error());
    $resCnt = mysqli_fetch_row($cnt);
    $id_ip = $resCnt[1];
    if ($resCnt[0] == 0)
    {
        mysqli_query($link, "INSERT INTO ip_user (client_ip) VALUES ('$client_ip')") or die(mysqli_error());
        $id_ip = mysqli_insert_id($link);
    }
    poiskldap($user);
    $fioLd = $_SESSION['fioLd'];
    $cnt = mysqli_query($link, "SELECT count(*),id_user FROM users WHERE login = '".$user."' LIMIT 1") or die(mysqli_error());
    $resCnt = mysqli_fetch_row($cnt);
    $id_user = $resCnt[1]; if($id_user == 1) {$adm = 0;}
    if ($resCnt[0] == 0)
    {
        mysqli_query($link, "INSERT INTO users (login,fio) VALUES ('$user','$fioLd')") or die(mysqli_error());
        $id_user = mysqli_insert_id($link);
    }
    $cnt = mysqli_query($link, "SELECT count(*),id_dolzh FROM dolzh WHERE dolzhnost = '".$_SESSION[dlznst]."' LIMIT 1") or die(mysqli_error());
    $resCnt = mysqli_fetch_row($cnt);
    $id_dolzh = $resCnt[1];
    if ($resCnt[0] == 0)
    {
        mysqli_query($link, "INSERT INTO dolzh (dolzhnost) VALUES ('$_SESSION[dlznst]')") or die(mysqli_error());
        $id_dolzh = mysqli_insert_id($link);
    }
    $cnt = mysqli_query($link, "SELECT count(*),id_dn FROM varDn WHERE dn = '".$vDN."' LIMIT 1") or die(mysqli_error());
    $resCnt = mysqli_fetch_row($cnt);
    $id_dn = $resCnt[1];
    if ($resCnt[0] == 0)
    {
        mysqli_query($link, "INSERT INTO varDn (dn) VALUES ('$vDN')") or die(mysqli_error());
        $id_dn = mysqli_insert_id($link);
    }
    $cnt = mysqli_query($link, "SELECT count(*),id_host FROM host WHERE host = '".$host."' LIMIT 1") or die(mysqli_error());
    $resCnt = mysqli_fetch_row($cnt);
    $id_host = $resCnt[1];
    if ($resCnt[0] == 0)
    {
        mysqli_query($link, "INSERT INTO host (host) VALUES ('$host')") or die(mysqli_error());
        $id_host = mysqli_insert_id($link);
    }
    $sql = "INSERT INTO userlog (date_srv, datehost, id_host, id_user,  id_ip, clName, id_IPAdrs, id_MACAdrs, id_mac, adm)
                             VALUES (NOW(), '$dtime', '$id_host', '$id_user',  '$id_ip', '$clName', '$id_IPAdrs', '$id_MACAdrs', '$mac_once[0]', '$adm')";
    if(!mysqli_query($link, $sql))
    {echo '<p><strong>Data upload error!</strong></p>';}
    else
    {echo '<p><strong>OK</strong></p>';}
    unset($dtime,$host,$user,$adm,$clName,$client_ip);
    @mysqli_close($link) or die("No close database!");
} else	{ echo '<p><strong>Ошибка!</strong></p>'; exit; }
?>