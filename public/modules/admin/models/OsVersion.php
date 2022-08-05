<?php

namespace app\modules\admin\models;

use Yii;

/**
 * Версия ОС
 */
class OsVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osVersion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Версия ОС',
        ];
    }

    public static function getId($name){
        $query = self::find()->where(['name' => $name]);
        $count = $query->count();
        if($count > 0){
            $id = $query->one();
            return $id->id;
        }else{
            $new_depart = new self();
            $new_depart->name = $name;
            $new_depart->save();

            $id = $query->one();
            return $id->id;
        }
    }


    /**
     * приводим текст в нормальный вид
     * Вход 10.0.14393_1_64
     * Ввыод Win10_64
     *
     * @param $os
     */
    public static function osName($os){

        if (isset($os)){
            $number = explode('_', $os); //10.0.14393_1_64
            if (isset($number[2])){
                $osVer = explode('.', $number[0]); //получаем массив из версии ОС 10.0.14393
                $osVersion = $osVer[0].'.'.$osVer[1]; // Получаем первые 2 эелемнта для версии ОС 10.0

                $architecture = $number[2]; //Разрядность ОС
                if(isset($number[1])){
                    //$number[1] - тип Ос, 1=клиентская, 2=серверная
                    if($number[1] == 1){
                        return OsVersion::osListClient($osVersion).'/'.$architecture; //получаем название ОС
                    }else{
                        return OsVersion::osListServer($osVersion).'/'.$architecture; //получаем название ОС
                    }
                }else{
                    return $osVersion;
                }
            }

        }

    }

    /**
     * @param $number
     * @return string
     * список ОС для клиентов
     */
    public static function osListClient($number){
        switch ($number) {
            case 10:
                return "Win10";
                break;
            case 6.3:
                return "Win8.1";
                break;
            case 6.2:
                return "Win8";
                break;
            case 6.1:
                return "Win7";
                break;
            case 6.0:
                return "WinVista";
                break;
            case 5.2:
                echo "WinXP";
                break;
            default:
                return $number;
        }
    }

    /**
     * @param $number
     * @return string
     * список ОС для Серверов
     */
    public static function osListServer($number){
        switch ($number) {
            case 10:
                return "Win2016";
                break;
            case 6.3:
                return "Win2012R2";
                break;
            case 6.2:
                return "Win2012";
                break;
            case 6.1:
                return "Win2008R2";
                break;
            case 6.0:
                return "Win2008";
                break;
            case 5.2:
                echo "Win2003";
                break;
            default:
                return $number;
        }
    }
}
