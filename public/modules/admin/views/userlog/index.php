<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>
<div class="userlog-index">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            'id',
//            'date_srv',
            'datehost',
            'id_host' => [
                'attribute' => 'id_host',
                'value' => 'host.host',
                'format' => 'html',
            ],
//             'server',
            'id_use' => [
                'attribute' => 'id_user',
                'value' => 'userName.login',
                'format' => 'html',
            ],
             'id_user' => [
                 'attribute' => 'id_user',
                 'value' => 'userName.fio',
                 'format' => 'html',
             ],
             'id_ip' => [
                 'attribute' => 'id_ip',
                 'value' => 'ip.client_ip',
                 'format' => 'html',
             ],
//             'client_ip2',
//             'adm',
//             'clName',
//             'id_IPAdrs',
//             'id_MACAdrs',
//             'id_dn',
             'id_dolzh' => [
                 'attribute' => 'id_dolzh',
                 'value' => 'dolzh.dolzhnost',
                 'format' => 'html',
             ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
