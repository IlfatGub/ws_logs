<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Userlog */

$this->title = 'Create Userlog';
$this->params['breadcrumbs'][] = ['label' => 'Userlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
