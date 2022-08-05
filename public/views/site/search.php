<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use app\modules\admin\models\Users;
use yii\helpers\ArrayHelper;
?>

<?php $form = ActiveForm::begin(['id' =>'form_search', 'method' => 'get']); ?>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($searchModel, 'id_host')->textInput() ?>
    </div>
    <div class="col-sm-2">
        <?php
        echo $form->field($searchModel, 'id_user')->widget(TypeaheadBasic::classname(), [
            'data' => ArrayHelper::map(Users::find()->all(),'login','login'),
            'pluginOptions' => ['highlight'=>true],
            'dataset' => ['limit' => 15],
        ]);
        ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($searchModel, 'id_ip')->textInput() ?>
    </div>
    <div class="col-sm-4">
        <?php
        echo $form->field($searchModel, 'id_user_fio')->widget(TypeaheadBasic::classname(), [
            'data' => ArrayHelper::map(Users::find()->all(),'fio','fio'),
            'pluginOptions' => ['highlight'=>true],
            'dataset' => ['limit' => 15],
        ]);
        ?>
    </div>
    <div class="col-sm-2">
        <label>Поиск</label><br>
        <?= Html::submitButton('' , ['class' => 'btn btn-primary col-sm-12 glyphicon glyphicon-search']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<div class="userlog-index">
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'summary' => '',
        'id' => 'grid-id',
        'tableOptions' => ['class' => 'table table-condensed table-bordered table-hover table-striped'],
        'columns' => [
            'id_host' => [
                'attribute' => 'id_host',
                'value' => 'host.host',
                'format' => 'html',
            ],
            'id_user' => [
                'attribute' => 'id_user',
                'value' => 'user.login',
                'format' => 'html',
            ],
            'datehost',
            'id_ip' => [
                'attribute' => 'id_ip',
                'value' => 'ip.client_ip',
                'format' => 'html',
            ],
            'id_user_fio' => [
                'attribute' => 'id_user_fio',
                'value' => 'user.fio',
                'format' => 'html',
            ],
            'id_user_post' => [
                'attribute' => 'id_user_post',
                'value' => 'user.post',
                'format' => 'html',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
