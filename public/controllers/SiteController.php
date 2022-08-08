<?php

namespace app\controllers;

use app\models\User;
use app\modules\admin\models\Bios;
use app\modules\admin\models\Host;
use app\modules\admin\models\IpUser;
use app\modules\admin\models\MacUser;
use app\modules\admin\models\OsVersion;
use app\modules\admin\models\Processor;
use app\modules\admin\models\Sysmodel;
use app\modules\admin\models\Temp;
use app\modules\admin\models\Test;
use app\modules\admin\models\Users;
use app\modules\admin\models\Videocard;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\admin\models\UserlogSearch;
use app\modules\admin\models\Userlog;
use app\modules\admin\models\UserSearch;
use app\models\SearchForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\data\Pagination;



class SiteController extends Controller
{
	const QUERY_LIMIT = 200;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [

				'class' => AccessControl::className(),
				'only' => ['index', 'update', 'create', 'view', 'delete'],
				'rules' => [
					[
						'allow' => true,
						'ips' => ['10.224.30.*', '10.224.12.*', '10.224.7.219', '10.224.7.205', '10.224.177.1'],
					],
				],
			],
		];
	}

	public function beforeAction($action)
	{

		Temp::firstConnect();

		$model = new SearchForm();
		if ($model->load(Yii::$app->request->post())) {
			$search = Html::encode($model->search);
			return $this->redirect(Url::toRoute(['index', 'search' => $search]));
		}
		return true;
	}

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/*
     * Колчиество пользователей за определенную дату
     */
	public function actionLink()
	{
		$date = Yii::$app->request->post() ? Yii::$app->request->post('date') : date('Y-m-d');


		$queryUser = Userlog::find()
			->joinWith(['host' => function ($q) {
				$q->select(['id_host', 'host']);
			}])
			//            ->joinWith(['users' => function($q) { $q->select(['id_user','login', 'fio', 'post', 'depart']); }])
			->joinWith(['users'])
			->joinWith(['ip' => function ($q) {
				$q->select(['id_ip', 'client_ip']);
			}])
			//            ->select(['users.login', 'users.id_user', 'host.host', 'datehost', 'id_IPAdrs' ])
			//            ->distinct(['users.login'])
			//            ->groupBy(['users.login'])
			//            ->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG']])
			->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG']])
			//            ->andFilterWhere(['like', 'users.login', ['SNHRS']])
			//            ->andFilterWhere(['not like', 'users.login', ['17']])
			->andFilterWhere(['>', 'datehost', $date_to . ' 00:00:00'])
			->andFilterWhere(['<', 'datehost', $date . ' 23:59:59']);

		$list = $queryUser->all();

		$countUser = $queryUser->count(); // Количество входов пользователей за сегодня

		$uniqueUser = $queryUser->select(['userlog.id_user'])->orderBy(['userlog.id_user' => SORT_ASC])->distinct()->count(); //Количество уникальных входов пользователей за сегодня

		return $this->render('link', [
			'countUser' =>  $countUser,
			'uniqueUser' => $uniqueUser,
			'date' => $date,
			'list' => $list,
		]);
	}

	public function actionLogsList($page = 1, $search = null)
	{
		$query = Userlog::find();

		$query
			->joinWith(['ip' => function ($q) {
				$q->select(['id_ip', 'client_ip']);
			}])
			->joinWith(['host' => function ($q) {
				$q->select(['id_host', 'host']);
			}])
			->joinWith(['users'])
			->joinWith(['os'])
			->joinWith(['processor'])
			->joinWith(['users'])
			->joinWith(['mac']);

		if ($search) {
			if (substr($search, 0, 1) == "=") {
				$query
					->orFilterWhere(['=', 'users.fio_text',           substr($search, 1)])
					->orFilterWhere(['=', 'users.login',         'SNHRS\\' . substr($search, 1)])
					->orFilterWhere(['=', 'host.host',           substr($search, 1)])
					->orFilterWhere(['=', 'ip_user.client_ip',   substr($search, 1)]);
			} else {
				$query
					->orFilterWhere(['like', 'users.fio_text',          $search])
					->orFilterWhere(['like', 'users.login',        $search])
					->orFilterWhere(['like', 'host.host',          $search])
					->orFilterWhere(['like', 'ip_user.client_ip',  $search]);
			}
		}


		$pages = Temp::getCount() * $page;

		$query->orderBy(['datehost' => SORT_DESC]);

		$temp = Temp::getType();
		if ($temp == Temp::QUERY_PC) {
			$query->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG', 'ZSM-DOC']]);
		} elseif ($temp == Temp::QUERY_SRV) {
			$query->andFilterWhere(['not like', 'host.host', ['ZS0', 'KA0', 'NH0', 'SN0']]);
		}
		$model = $query
			->limit(Temp::getCount())
			->offset($pages)
			->all();

		return $this->renderAjax('logsList', compact(['model', 'page']));
	}

	public function actionIndex($search = null)
	{
		$query = Userlog::find();

		$query

			->joinWith(['ip' => function ($q) {
				$q->select(['id_ip', 'client_ip']);
			}])
			->joinWith(['host' => function ($q) {
				$q->select(['id_host', 'host']);
			}])
			->joinWith(['users'])
			->joinWith(['os'])
			->joinWith(['processor'])
			->joinWith(['users'])
			->joinWith(['mac']);

		if (strlen($search) > 0) {
			if (substr($search, 0, 1) == "=") {
				$query
					->orFilterWhere(['=', 'users.fio_text',           substr($search, 1)])
					->orFilterWhere(['=', 'users.login',         'SNHRS\\' . substr($search, 1)])
					->orFilterWhere(['=', 'host.host',           substr($search, 1)])
					->orFilterWhere(['=', 'ip_user.client_ip',   substr($search, 1)]);
			} else {
				$query
					->orFilterWhere(['like', 'users.fio_text',           $search])
					->orFilterWhere(['like', 'users.login',        $search])
					->orFilterWhere(['like', 'host.host',          $search])
					->orFilterWhere(['like', 'ip_user.client_ip',  $search]);
			}
		}

		$queryUser = Userlog::find()
			->joinWith(['host' => function ($q) {
				$q->select(['id_host', 'host']);
			}])
			->select('userlog.id_user')
			->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG', 'ZSM-DOC', 'RDSH']])
			->andFilterWhere(['>', 'userlog.datehost', date('Y-m-d') . ' 00:00:00'])
			->andFilterWhere(['<', 'userlog.datehost', date('Y-m-d') . ' 23:59:59']);

		$countUser = $queryUser->count(); // Количество входов пользователей за сегодня
		$uniqueUser = $queryUser->distinct()->count(); //Количество уникальных входов пользователей за сегодня

		$query->orderBy(['datehost' => SORT_DESC]);

		$temp = Temp::getType();
		if ($temp == Temp::QUERY_PC) {
			$query->andFilterWhere(['not like', 'host.host', ['SRV', '1C', 'STS', 'SMS', 'VC', 'LYNC', 'DOC', 'KA-MBX1', 'KA-DC1', 'MBX', 'TMG', 'ZSM-DOC', 'RDSH']]);
		} elseif ($temp == Temp::QUERY_SRV) {
			$query->andFilterWhere(['not like', 'host.host', ['ZS0', 'KA0', 'NH0', 'SN0']]);
		}
		$model = $query
			->limit(Temp::getCount())
			->all();

		return $this->render('index', [
			'model' => $model,
			'countUser' => $countUser,
			'uniqueUser' => $uniqueUser,
		]);
	}

	public function actionAdd()
	{
		$model = new Userlog();

		$user = !empty($_POST['user']) ? $_POST['user'] : null;
		$host = !empty($_POST['host']) ? $_POST['host'] : null;
		$IPAdrs = !empty($_POST['IPAdrs']) ? $_POST['IPAdrs'] : null;
		$MACAdrs = !empty($_POST['MACAdrs']) ? $_POST['MACAdrs'] : null;
		$dtime  = !empty($_POST['dtime']) ? $_POST['dtime'] : date('Y-m-d H:i:s');
		$endTime  = !empty($_POST['time']) ? $_POST['time'] : null;

		$osVersion = !empty($_POST['OS']) ? $_POST['OS'] : null;

		$RAM = !empty($_POST['RAM']) ? $_POST['RAM']  : null;
		$HDD = !empty($_POST['HDD']) ? $_POST['HDD']  : null;
		$Processor = !empty($_POST['Processor']) ? $_POST['Processor']  : null;

		$ips = explode(' ', $IPAdrs);
		$macs = explode(' ', $MACAdrs);

		$test = new Test();
		$test->text = $user . '__' . $host . '__' . array_shift($ips) . '__' . array_shift($macs) . '__ENdTime__' . $endTime . '__osVersion__' . $osVersion . '__RAM__' . $RAM . '__Processor__' . $Processor . '__HDD__' . $HDD;
		$test->date = $dtime;
		$test->save();


		try {
			if (isset($user)) {
				$model->date_srv = date('Y-m-d H:i:s');
				$model->datehost = $dtime;
				$model->id_user = Users::getIdFio($user);
				$model->id_host = Host::getIdHost($host);
				$model->adm = null;
				$model->id_ip = IpUser::getIdIp($IPAdrs);
				$model->id_IPAdrs = IpUser::getMassivIdIp($IPAdrs);
				$model->id_mac = MacUser::getIdMac($MACAdrs);
				$model->id_osversion = $osVersion ? OsVersion::getId($osVersion) : null;
				$model->id_processor = $Processor ? Processor::getId($Processor) : null;
				$model->LastBootUpTime = $endTime;
				$model->ram = $RAM;
				$model->save();
			}
		} catch (\Exception $ex) {
			$test = new Test();
			$test->text = $ex->getMessage();
			$test->date = $dtime;
			$test->save();
		}




		return $this->render('add');
	}

	public function actionSearch()
	{
		$searchModel = new UserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('search', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionClear()
	{
		$connection = \Yii::$app->db;
		$now = date('Y-m-d');
		$date = date('Y-m-d', strtotime($now . ' - 20 month'));

		$model = $connection->createCommand("INSERT INTO userlogOld SELECT * FROM userlog WHERE datehost < :datehost")
			->bindValue(':datehost', $date);
		$model->execute();

		Userlog::deleteAll(['<', 'datehost', $date]);

		echo 'Ok!';
		die();
	}

	public function actionLdap()
	{
		$model = Users::find()->all();

		return $this->render('ldap', [
			'model' => $model,
		]);
	}

	public function actionQuery()
	{

		//        if( !empty($_POST['dtime']) and !empty($_POST['host']) and !empty($_POST['user']) ){
		//            $dtime = $_POST['dtime'];	unset($_POST['dtime']);
		//            $host = $_POST['host'];		unset($_POST['host']);
		//            $user = $_POST['user'];		unset($_POST['user']);
		//            $clName = ($_POST['clName'] == '%CLIENTNAME%') ? '' : $_POST['clName']; unset($_POST['clName']);
		//            $client_ip = $_SERVER['REMOTE_ADDR'];
		//            $IPAdrs = $_POST['IPAdrs'];		unset($_POST['IPAdrs']);
		//            $MACAdrs = $_POST['MACAdrs'];	unset($_POST['MACAdrs']);
		//
		//            $count = Users::find()->where(['login' => $user])->count();
		//            if($count > 0){
		//                $userId = Users::findOne(['login' => $user])->id_user;
		//            }else{
		//                $model = new Users();
		//                $model->login = $user;
		//                $model ->save();
		//
		//                $models = Users::find()->limit('1')->orderBy(['id' => SORT_DESC])->one();
		//                $userId = $models->id_user;
		//            }
		//
		//            $count = Host::find()->where(['host' => $host])->count();
		//            if($count > 0){
		//                $hostId = Host::findOne(['host' => $host])->id_host;
		//            }else{
		//                $model = new Host();
		//                $model->host = $host;
		//                $model ->save();
		//
		//                $models = Host::find()->limit('1')->orderBy(['id' => SORT_DESC])->one();
		//                $hostId = $models->id_host;
		//            }
		//
		//            $count = IpUser::find()->where(['client_ip' => $IPAdrs])->count();
		//            if($count > 0){
		//                $ipId = IpUser::findOne(['client_ip' => $IPAdrs])->id_ip;
		//            }else{
		//                $model = new IpUser();
		//                $model->client_ip = $IPAdrs;
		//                $model ->save();
		//
		//                $models = IpUser::find()->limit('1')->orderBy(['id' => SORT_DESC])->one();
		//                $ipId = $models->id_ip;
		//            }
		//
		//            $count = MacUser::find()->where(['client_mac' => $MACAdrs])->count();
		//            if($count > 0){
		//                $macId = MacUser::findOne(['client_mac' => $MACAdrs])->id_mac;
		//            }else{
		//                $model = new MacUser();
		//                $model->client_ip = $IPAdrs;
		//                $model ->save();
		//
		//                $models = MacUser::find()->limit('1')->orderBy(['id' => SORT_DESC])->one();
		//                $macId = $models->id_ip;
		//            }
		//
		//
		//            $userlogs = new Userlog();
		//            $userlogs->date_srv = date('Y-mm-d h:i:s');
		//            $userlogs->datehost = $dtime;
		//            $userlogs->id_host = $hostId;
		//            $userlogs->id_user = $userId;
		//            $userlogs->id_ip = $ipId;
		//            $userlogs->id_MACAdrs = $macId;
		//            $userlogs->save();
		//
		//            echo "123123";
		//        }
		//        echo "qq";

		$model = new Userlog();
		$model->id_host = 777;
		$model->date_srv = date("Y-m-d h:i:s");
		$model->save();
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}


	public function actionTemp($count = null, $type = null)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = Temp::find()->where(['ip' => $ip]);
		if ($query->exists()) {
			$model = $query->one();
			$model->count = isset($count) ? $count : $model->count;
			$model->type = isset($type) ? $type : $model->type;
			$model->save();
		} else {
			$model = new Temp();
			$model->ip = $ip;
			$model->count = isset($count) ? $count : null;
			$model->type = isset($type) ? $type : null;
			$model->save();
		}
	}

	public function actionHelp()
	{


		return $this->render('help');
	}

	public function actionAbout()
	{
		return $this->render('about');
	}
}
