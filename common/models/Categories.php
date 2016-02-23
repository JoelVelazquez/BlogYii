<?php

namespace common\models;

use Yii;
use backend\models\Posts;
/**
 * This is the model class for table "categories".
 *
 * @property string $id_category
 * @property string $name
 * @property string $description
 * @property integer $publications
 * @property integer $status
 * @property integer $counter
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'name', 'description'], 'required'],
            [['id_category', 'publications', 'status', 'counter'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_category' => Yii::t('app', 'Id Category'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'publications' => Yii::t('app', 'Publications'),
            'status' => Yii::t('app', 'Status'),
            'counter' => Yii::t('app', 'Counter'),
        ];
    }

     public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['publications' => 'id_post']);
    }
}