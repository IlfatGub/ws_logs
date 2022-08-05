<?php
/**
 * Created by PhpStorm.
 * User: 01gig
 * Date: 23.09.2016
 * Time: 13:01
 */
$i=0;


use app\modules\admin\models\Userlog;
//foreach ($model as $item) {
//    echo $i++;
//    Userlog::deleteUserlog($item->id);
//    echo $item->datehost."<br>";
//}


echo date('Y-m-d h:i:s');
echo "<br>";
$date = date('m-d h:i:s');
$y =  date('Y') - 1;

echo $y.'-'.$date;

echo "<br>";
for ($i = 0; $i <= 6; $i++){
    echo $i.'<br>';
    Userlog::clearUserlog();
}