<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Userlog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Userlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userlog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date_srv',
            'datehost',
            'id_host',
            'host2',
            'server',
            'id_user',
            'user2',
            'id_ip',
            'client_ip2',
            'adm',
            'clName',
            'id_IPAdrs',
            'id_MACAdrs',
            'id_dn',
            'id_dolzh',
        ],
    ]) ?>

</div>
