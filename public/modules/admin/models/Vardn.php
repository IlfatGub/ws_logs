<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "dolzh".
 *
 * @property integer $id_dolzh
 * @property string $dolzhnost
 */
class Vardn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'varDn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dn'], 'text'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dn' => 'Id Dolzh',
            'dn' => 'Dolzhnost',
        ];
    }
}
