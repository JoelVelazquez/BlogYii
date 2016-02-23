<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $role_name
 * @property integer $role_value
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_name', 'role_value'], 'required'],
            [['id', 'role_value'], 'integer'],
            [['role_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_name' => Yii::t('app', 'Role Name'),
            'role_value' => Yii::t('app', 'Role Value'),
        ];
    }

    /**
    * get role relationship
    *
    */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['role_value' => 'role_id']);
    }

    /**
    * get role name
    *
    */
    public function getRoleName()
    {
        return $this->role ? $this->role->role_name : '- no role -';
    }

    /**
    * get list of roles for dropdown
    */
    public static function getRoleList()
    {
        $droptions = Role::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'role_value', 'role_name');
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id' => 'role_value']);
    }

}
