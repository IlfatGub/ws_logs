<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Userlog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userlog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_srv')->textInput() ?>

    <?= $form->field($model, 'datehost')->textInput() ?>

    <?= $form->field($model, 'id_host')->textInput() ?>

    <?= $form->field($model, 'host2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'server')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'user2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_ip')->textInput() ?>

    <?= $form->field($model, 'client_ip2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adm')->textInput() ?>

    <?= $form->field($model, 'clName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_IPAdrs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_MACAdrs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_dn')->textInput() ?>

    <?= $form->field($model, 'id_dolzh')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
