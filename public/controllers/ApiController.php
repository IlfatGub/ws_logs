<?php

namespace app\controllers;

use app\modules\admin\models\Userlog;
use yii\helpers\Html;
use yii\rest\ActiveController;
use app\models\Api;


class ApiController extends ActiveController
{
    public $modelClass = 'app\models\Api';

    public function actions()
    {
        $action = parent::actions();
        unset($action['index']);
        return $action;
    }

    public function actionIndex($search = null, $limit = 10)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($search) {
            $search = str_replace('_', ' ', $search);
            $model = Userlog::find()
                ->joinWith(['users'])
                ->joinWith(['ip' => function ($q) {
                    $q->select(['id_ip', 'client_ip']);
                }])
                ->joinWith(['host' => function ($q) {
                    $q->select(['id_host', 'host']);
                }])
                ->joinWith(['mac' => function ($q) {
                    $q->select(['id_mac', 'client_mac']);
                }])
                ->orderBy(['datehost' => SORT_DESC])
                ->orFilterWhere(['like', 'users.fio_text', $search])
                ->orFilterWhere(['like', 'ip_user.client_ip', $search])
                ->limit($limit)
                ->all();
        } else {
            $model = Userlog::find()
                ->joinWith(['users'])
                ->joinWith(['ip' => function ($q) {
                    $q->select(['id_ip', 'client_ip']);
                }])
                ->joinWith(['host' => function ($q) {
                    $q->select(['id_host', 'host']);
                }])
                ->orderBy(['datehost' => SORT_DESC])
                ->limit($limit)
                ->all();
        }
        if (count($model) > 0) {
            $i = 0;
            $data = array();
            foreach ($model as $item) {
                $data[$i]['datehost'] = $item->datehost;
                $data[$i]['host'] = $item->host->host;
                $data[$i]['login'] = $item->users->login;
                $data[$i]['dolzhnost'] = $item->users->post_text;
                $data[$i]['mac'] = $item->mac->client_mac;
                $data[$i]['depart'] = $item->users->depart_text;
                $data[$i]['name'] = $item->users->fio_text;
                $data[$i]['ip'] = $item->ip->client_ip;
                $data[$i]['phone'] = $item->users->phone;
                ++$i;
            }
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false, 'data' => 'Нет данных'];

        }
    }

    public function actionDomain($fio = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = array();
        if ($fio) {
            $model = Userlog::find()
                ->select(['users.*', 'ip_user.*' , 'host.*', 'userlog.*' ])
                ->joinWith(['users'])
                ->joinWith(['host'])
                ->joinWith(['ip' => function ($q) {
                    $q->select(['id_ip', 'client_ip']);
                }])
                ->orderBy(['datehost' => SORT_DESC])
                ->andFilterWhere(['=', 'users.fio_text', HTML::encode($fio)])
                ->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG','RDSH']])
                ->limit(1)
                ->one();
        }

        if ($model) {
            $data = array();

            $data['host'] = isset($model->host->host) ? $model->host->host : null ;
            $data['login'] = isset($model->users->login) ? $model->users->login : null ;
            $data['ip'] = isset($model->ip->client_ip) ? $model->ip->client_ip : null;
            $data['datehost'] = isset($model->_datehost) ? $model->_datehost : null;
            $data['LastBootUpTime'] = isset($model->LastBootUpTime) ? $model->LastBootUpTime : null;

            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false, 'data' => 'Нет данных'];

        }
    }
}

