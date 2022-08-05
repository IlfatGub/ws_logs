<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\UserlogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userlog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_srv') ?>

    <?= $form->field($model, 'datehost') ?>

    <?= $form->field($model, 'id_host') ?>

    <?= $form->field($model, 'host2') ?>

    <?php // echo $form->field($model, 'server') ?>

    <?php // echo $form->field($model, 'id_user') ?>

    <?php // echo $form->field($model, 'user2') ?>

    <?php // echo $form->field($model, 'id_ip') ?>

    <?php // echo $form->field($model, 'client_ip2') ?>

    <?php // echo $form->field($model, 'adm') ?>

    <?php // echo $form->field($model, 'clName') ?>

    <?php // echo $form->field($model, 'id_IPAdrs') ?>

    <?php // echo $form->field($model, 'id_MACAdrs') ?>

    <?php // echo $form->field($model, 'id_dn') ?>

    <?php // echo $form->field($model, 'id_dolzh') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
