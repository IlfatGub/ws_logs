<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\helpers\Url;

?>

<?php Pjax::begin(); ?>
<?= Html::beginForm(['site/link'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>

<?=
// usage without model
 DatePicker::widget([
    'name' => 'date',
    'value' => $date,
    'options' => ['placeholder' => 'Select issue date ...'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose'=>true,
    ]
]);
?>

<!--<pre>-->
<!--    --><?php // print_r($list) ?>
<!--</pre>-->

<?= Html::submitButton('Выполнить ', ['class' => 'btn btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
    <h3>Всего подключений: <?=  $countUser ?></h3>
    <h3>Уникальных подкл.:<?= $uniqueUser ?></h3>



<table class="table table-bordered table-condensed table-striped" style="font-size: 10pt">
    <tr>
        <td>Логин</td>
        <td>IP</td>
        <td>Имя ПК</td>
        <td>Логин</td>
        <td>ФИО</td>
        <td>Должность</td>
        <td>Дата Входа</td>
    </tr>
    <?php foreach ($list as $item){ ?>
        <tr>
            <td>
                <?= $item->users->login ?>
            </td>
            <td>
                <?= $item->ip->client_ip ?>
            </td>
            <td style="width: 120px">
                <?= $item->host->host ?>
            </td>
            <td>
                <a href="<?= Url::toRoute(['index', 'search' =>  '='.$item->users->fio]) ?>" data-toggle="tooltip" data-placement="right" title="<?= $item->users->depart_text ?>" style="border-bottom: 1px dotted #777; cursor: help"?>
                    <?= $item->users->login ?>
                </a>
            </td>
            <td> <?= $item->users->fio_text ?> </td>
            <td> <?= $item->users->post_text ?> </td>
            <td> <?= $item->datehost ?> </td>
        </tr>
    <?php } ?>
</table>

<?php Pjax::end(); ?>
