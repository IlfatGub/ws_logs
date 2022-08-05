<?php

use app\modules\admin\models\OsVersion;
use yii\helpers\Url;

?>

    <?php $i = $page * \app\modules\admin\models\Temp::getCount(); + 1  ?>
    <?php foreach ($model as $item) { ?>
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
