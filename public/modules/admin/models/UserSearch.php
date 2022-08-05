<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Userlog;

/**
 * UserlogSearch represents the model behind the search form about `app\modules\admin\models\Userlog`.
 */
class UserSearch extends Userlog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_host', 'id_user', 'id_ip', 'adm', 'id_dn', 'id_dolzh', 'id_user_fio'], 'safe'],
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
            ->select(['datehost', 'ip_user.id_ip', 'host.id_host', 'users.id_user' ])
            ->orderBy(['date_srv'=>SORT_DESC])
            ->limit(30);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => 1000,
            'pagination' => [
                'pageSize' => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('host');
        $query->joinWith('user');
        $query->joinWith('ip');


        $query->orFilterWhere(['like', 'users.login', $this->id_user])
            ->orFilterWhere(['like', 'host.host', $this->id_host])
            ->orFilterWhere(['like', 'datehost', $this->datehost])
            ->orFilterWhere(['like', 'ip_user.client_ip', $this->id_ip])
            ->orFilterWhere(['like', 'users.fio', $this->id_user_fio]);

        return $dataProvider;
    }
}
