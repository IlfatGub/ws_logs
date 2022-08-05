<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "host".
 *
 * @property integer $id_host
 * @property string $host
 */
class Host extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'host';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host'], 'required'],
            [['host'], 'string', 'max' => 20],
            [['host'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_host' => 'Id Host',
            'host' => 'Host',
        ];
    }

    public function getIdHost($host){
        $host_query = Host::find()->where(['host' => $host]);
        $count = $host_query->count();
        if($count > 0){
            $host = $host_query->one();
            return $host->id_host;
        }else{
            $new_host = new Host();
            $new_host->host = $host;
            $new_host->save();

            $host = $host_query->one();
            return $host->id_host;
        }
    }
}
