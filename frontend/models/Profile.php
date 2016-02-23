<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
//'class' => 'yii\behaviors\TimestampBehavior';
//blogyii\vendor\\yiisoft\yii2\behaviours;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $avatar
 * @property string $filename
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'birthdate', 'gender_id'], 'required'],
            [['id', 'user_id', 'gender_id'], 'integer'],
            [['gender_id'],'in', 'range'=>array_keys($this->getGenderList())],
            [['first_name', 'last_name'], 'string'],
            [['avatar', 'filename'], 'string', 'max' => 250],
            [['gender_id'],'in', 'range'=>array_keys($this->getGenderList())],
            [['birthdate'], 'date', 'format'=>'Y-m-d'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'gender_id' => Yii::t('app', 'Gender ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'avatar' => Yii::t('app', 'Avatar'),
            'filename' => Yii::t('app', 'Filename'),

            'genderName' => Yii::t('app', 'Gender'),
            'userLink' => Yii::t('app', 'User'),
            'profileIdLink' => Yii::t('app', 'Profile'),
        ];
    }

     public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                            ],
            'value' => new Expression('NOW()'),
                           ],
               ];
    }

    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    public function getGenderName()
    {
        return $this->gender->gender_name;
    }

    public static function getGenderList()
    {
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUsername()
    {
        return $this->user->username;
    }

    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
    }

    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id'=>$this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }

    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

}