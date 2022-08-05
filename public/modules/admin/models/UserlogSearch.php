<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Userlog;

/**
 * UserlogSearch represents the model behind the search form about `app\modules\admin\models\Userlog`.
 */
class UserlogSearch extends Userlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_host', 'id_user', 'id_ip', 'adm', 'id_dn', 'id_dolzh', 'id_user_fio', 'search'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Userlog::find()
            ->select(['host.host'])
//            ->limit(30)
            ->orderBy(['date_srv'=>SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'pageSizeLimit' => 1,
            ],
//            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       $query->join('INNER JOIN', Host::tableName(), 'host.id_host = userlog.id_host');
//       $query->join('INNER JOIN', Users::tableName(), 'users.id_user = userlog.id_user');
//       $query->join('INNER JOIN', IpUser::tableName(), 'ip_user.client_ip = userlog.id_ip');

//        $query
//            ->orFilterWhere(['like', 'users.login', $this->search])
//            ->orFilterWhere(['like', 'host.host', $this->search])
//            ->orFilterWhere(['like', 'ip_user.client_ip', $this->search])
//            ->orFilterWhere(['like', 'users.fio', $this->search])
//            ->orFilterWhere(['like', 'users.post', $this->search])
//            ->andFilterWhere(['>' , 'datehost', '2016-01-01 23:59:59']);


        return $dataProvider;
    }
}
