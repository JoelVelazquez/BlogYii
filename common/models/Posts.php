<?php

namespace common\models;

use Yii;
use backend\models\Categories;
/**
 * This is the model class for table "posts".
 *
 * @property integer $id_post
 * @property integer $created_by
 * @property string $title
 * @property string $excerpt
 * @property string $body
 * @property string $blog_category_id
 * @property integer $status
 * @property integer $comment_status
 * @property integer $comment_count
 * @property integer $views
 * @property string $publish_up
 * @property string $publish_down
 *
 * @property PostComments[] $postComments
 * @property Categories $blogCategory
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_post', 'created_by', 'title', 'excerpt', 'body', 'blog_category_id', 'status', 'comment_status'], 'required'],
            [['id_post', 'created_by', 'blog_category_id', 'status', 'comment_status', 'comment_count', 'views'], 'integer'],
            [['title', 'excerpt', 'body'], 'string'],
            [['publish_up', 'publish_down'], 'safe'],
            [['id_post'], 'unique'],
            [['blog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['blog_category_id' => 'id_category']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_post' => Yii::t('app', 'Id Post'),
            'created_by' => Yii::t('app', 'Created By'),
            'title' => Yii::t('app', 'Title'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'body' => Yii::t('app', 'Body'),
            'blog_category_id' => Yii::t('app', 'Blog Category ID'),
            'status' => Yii::t('app', 'Status'),
            'comment_status' => Yii::t('app', 'Comment Status'),
            'comment_count' => Yii::t('app', 'Comment Count'),
            'views' => Yii::t('app', 'Views'),
            'publish_up' => Yii::t('app', 'Publish Up'),
            'publish_down' => Yii::t('app', 'Publish Down'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComments::className(), ['blog_post_id' => 'id_post']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategory()
    {
        return $this->hasOne(Categories::className(), ['id_category' => 'blog_category_id']);
    }
}
