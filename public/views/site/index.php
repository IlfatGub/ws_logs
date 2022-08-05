<?php

use app\modules\admin\models\OsVersion;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use app\modules\admin\models\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<?php
$serach = new \app\models\SearchForm();
$get_search = isset($_GET['search']) ? $_GET['search'] : null;
?>

<style>
    .tooltip {
        margin-left: 25px;
    }
    .tooltip-inner{
        max-width: 400px
    }
    body {
        font-family: Verdana, Helvetica, Arial, sans-serif;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 3px;
        line-height: 1.42857143;
        vertical-align: top;
        font-size: 9pt;
        border-top: 1px solid #ddd;
    }
</style>

<?php
$script = <<<JS
    $(document).ready(function() {
        var page = 1;
        var inProgress = false;
        $(window).scroll(function() {
            var windowScroll = $(window).scrollTop();
            var windowHeihgt = $(window).height();
            var documentHeight = $(document).height();
            if((windowScroll + windowHeihgt) == documentHeight && !inProgress){
                Load();
            }
        });
        
        $('#load').click(function() {
            Load();
            $("#loadBtnBlock").hide();
        });
        
        function Load(){
            var search = '$get_search';
            $.ajax({
                url: "http://logs.snhrs.ru/index.php/logs-list",
                method: 'GET',
                data: {"page" : page, "search" : search},
                beforeSend: function() {
                    inProgress = true;
                }
            }).done(function(data) {
                console.log(data);
                // $("#contentAjax").append(data);
                $("#mytable").append(data);
                inProgress = false;
                page += 1;
            })
        }
    })
JS;

?>
    <div style="position: fixed; top: 5px; right: 50px; z-index: 99999;" class="list-group-item list-group-item-warning">
        <?= 'За сегодня: ' . $countUser ?>
        <?= 'Уникальных: ' . $uniqueUser ?>
    </div>

<?php $form = ActiveForm::begin(['action' => Url::toRoute(['index'])]); ?>
    <div class="row">
        <div class="col-sm-10">
            <div class="row">

                <div class="col-sm-2 bg-danger">
                    <?= Html::dropDownList('logs-count', 'logs-count',
                        [50 => 50, 150 => 150, 250 => 250, 400 => 400],
                        [
                            'id' => 'logs-count',
                            'class' => 'form-control  tt-input',
                            'options' => [
                                \app\modules\admin\models\Temp::getCount() => ['selected' => true] // Меняя цифру можно установить какой-либо элемент массива по умолчанию
                            ]
                        ]
                        ); ?>
                </div>

                <div class="col-sm-2 bg-danger">
                    <?= Html::dropDownList('logs-type', 'logs-type',
                        [1 => 'Только ПК', 2 => 'ПК и Сервера', 3 => 'Только Сервера'],
                        [
                            'id' => 'logs-type',
                            'class' => 'form-control  tt-input',
                            'options' => [
                                \app\modules\admin\models\Temp::getType() => ['selected' => true] // Меняя цифру можно установить какой-либо элемент массива по умолчанию
                            ]
                        ]
                    ); ?>
                </div>

                <div class=" row col-sm-8">
                    <div class="col-sm-10">
                        <?php
                        if(isset($_GET['search'])){
                            $serach->search = $_GET['search'];
                        }
                        echo $form->field($serach, 'search')->widget(TypeaheadBasic::classname(), [
                            'data' => ArrayHelper::map(Users::find()->select('fio')->distinct()->all(), 'fio', 'fio'),
                            'options' => [
                                'style' => 'font-size:10pt;',
                                'placeholder' => 'Поиск...',
                                'autofocus' => "autofocus",
                                'id' => 'search',
                            ],
                            'scrollable' => TRUE,
                            'dataset' => [
                                'limit' => 20,
                                'class' => 'sizes',
                            ],
                            'pluginOptions' => [
                                'highlight' => TRUE,
                                'minLength' => 2,
                            ],
                            'pluginEvents' => [
                                "typeahead:select" => "function() { location.href='http://logs.snhrs.ru/web/index.php/?search='+document.getElementById('search').value }",],
                        ])->label(false);
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?= Html::submitButton('', ['class' => 'btn btn-primary col-sm-12 glyphicon glyphicon-search']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<table class="table table-sm table-bordered " id="">

<?php ActiveForm::end(); ?>
    <tbody id="mytable">

        <tr>
            <td>#</td>
            <td>Pc_name</td>
            <td>Login</td>
            <td>Date</td>
            <td>Ip</td>
            <td>Fio</td>
            <td>OS ver.</td>
<!--            <td>Processor</td>-->
            <td>RAM</td>
            <td>LastBoot</td>
            <td>Post</td>
            <td>Phone</td>
        </tr>

        <?php $i = 1; ?>
        <?php foreach ($model as $item) { ?>
            <?php $os = isset($item->os->name) ? 'OsVersion:'. OsVersion::osName($item->os->name) : ''; ?>
            <?php $bios = isset($item->bios->name) ? 'Bios:'.$item->bios->name : ''; ?>
            <?php $sysmodel = isset($item->sysmodel->name) ? 'SysName:'.$item->sysmodel->name : ''; ?>
            <?php $processor = isset($item->processor->name) ? 'Processor:'.$item->processor->name : ''; ?>
            <?php $ram = isset($item->ram) ? 'Ram:'.$item->ram : ''; ?>
            <?php $videocard = isset($item->videocard->name) ? 'Video:'.$item->videocard->name : ''; ?>

            <?php $hardawareInformation = '' ?>
            <?php $hardawareInformation .= $os ?>
            <?php $hardawareInformation .= " <br> " . $processor ?>
            <?php $hardawareInformation .= " <br> " . $ram ?>
            <?php $hardawareInformation .= " <br> " . $sysmodel ?>
            <?php $hardawareInformation .= " <br> " . $videocard ?>
            <?php $hardawareInformation .= " <br> " . $bios ?>

            <?php $name_once = explode("\\", $item->users->login); ?>
            <?php if ($name_once[0] == "ZSMIK") {
                $style = 'background: #D9EDF7';
            } elseif ($name_once[0] == "NHRS") {
                $style = 'background: #FCF8E3';
            } elseif ($name_once[0] == "A-CONSALT") {
                $style = 'background: #F2DEDE';
            } else {
                $style = 'background: #FFFFFF';
            }


            ?>
            <tr style="<?= $style ?>; " class="tr-p-0 ">
                <td><?= $i ?></td>
                <td style="min-width: 100px">
                    <div style="margin: 0; padding: 0" class="btn btn-sm btn-info btn-clipboard " id="copy-button" data-clipboard-target="#post-shortlinkSN<?= $item->id ?>">C </div>
                    <a href="<?= Url::toRoute(['index', 'search' => '=' . $item->host->host]) ?>" data-toggle="tooltip"
                       id="post-shortlinkSN<?= $item->id ?>" title="<?= $item->mac->client_mac ?>"
                       style="border-bottom: 1px dotted #777; cursor: help" ?><?= $item->host->host ?></a>
                </td>

                <td>                    <?= $item->users->login ?>                </td>

                <td style="min-width: 120px"><?= $item->datehost ?></td>
                <td style="min-width: 120px">
                    <div style="margin: 0; padding: 0" class="btn btn-sm btn-info btn-clipboard " id="copy-button"
                            data-clipboard-target="#post-shortlink<?= $item->id ?>">C
                    </div>
                    <a href="<?= Url::toRoute(['index', 'search' => '=' . $item->ip->client_ip]) ?>"
                       id="post-shortlink<?= $item->id ?>"><?= $item->ip->client_ip ?></a>
                </td>
                <td style="min-width: 250px">
                    <a href="<?= Url::toRoute(['index', 'search' => '=' . isset($item->users->fio_text) ? $item->users->fio_text : '']) ?>"
                       data-toggle="tooltip" data-placement="right"
                       title="<?= isset($item->users->depart_text) ? $item->users->depart_text : '' ?>"
                       style="border-bottom: 1px dotted #777; cursor: help" ?>
                        <?= isset($item->users->fio_text) ? $item->users->fio_text : '' ?>
                    </a>
                </td>
                <td>
                    <?php echo isset($item->os->name) ? $item->os->name : ''; ?>
                </td>
<!--                <td>-->
<!--                    --><?php //echo isset($item->processor->name) ? $item->processor->name : ''; ?>
<!--                </td>-->
                <td>
                    <?= isset($item->ram) ? $item->ram.' GB' : ''; ?>
                </td>
                <td>
                    <?= isset($item->LastBootUpTime) ? $item->LastBootUpTime : ''; ?>
                </td>
                <td>
                    <?= isset($item->users->post_text) ? mb_substr($item->users->post_text, 0, 20, 'utf-8')  : ''; ?>
                </td>
                <td >
                    <div style="float: right;">
                        <?= !empty($item->users->phone) ? $item->users->phone : ''; ?>
                    </div>
                </td>
            </tr>


        <?php $i++; } ?>
    </tbody>

</table>

<div class="col-sm-6 col-sm-offset-3 well" style="margin-top: 15px" id="loadBtnBlock">
    <?= Html::button('Еще', ['id' => 'load', 'class' => 'btn btn-block btn-lg btn-primary ']) ?>
</div>

<script>
    new Clipboard('.btn-clipboard'); // Не забываем инициализировать библиотеку на нашей кнопке
</script>

<script>
    $(document).ready(function(){
        $("#search").keyup(function(){
            _this = this;
            $.each($("#mytable tbody tr"), function() {
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
    });
</script>
<?php
$this->registerJs($script);
?>
