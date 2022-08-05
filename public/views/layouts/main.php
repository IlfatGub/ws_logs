<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'SNHRS Logs',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '', 'url' => ['/site/help'], 'linkOptions' => ['class' => 'glyphicon glyphicon-question-sign', 'title'=>'Справка']],
            ['label' => '', 'url' => ['/site/link'], 'linkOptions' => ['class' => 'glyphicon glyphicon-time', 'title'=>'Справка']],
//            ['label' => '', 'url' => ['/site/ldap'], 'linkOptions' => ['data-confirm'=>"Вы действительно хотите обновить должности??", 'class' => 'glyphicon glyphicon-refresh ', 'title' => 'Обновить должности'],],
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container col-lg-10 col-lg-offset-1">
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



