<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_type".
 *
 * @property integer $id
 * @property string $user_type_name
 * @property integer $user_type_value
 */
class UserType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_type_name', 'user_type_value'], 'required'],
            [['user_type_value'], 'integer'],
            [['user_type_name'], 'string', 'max' => 45],
            [['user_type_id'],'in', 'range'=>array_keys($this->getUserTypeList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_type_name' => Yii::t('app', 'User Type Name'),
            'user_type_value' => Yii::t('app', 'User Type Value'),
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_type_id' => 'user_type_value']);
    }

    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['user_type_value' => 'user_type_id']);
    }

    public function getUserTypeName()
    {
        return $this->userType ? $this->userType->user_type_name : '- no user type -';
    }

    public static function getUserTypeList()
    {
        $droptions = UserType::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'user_type_value', 'user_type_name');
    }

    public function getUserTypeId()
    {
        return $this->userType ? $this->userType->id : 'none';
    }
}