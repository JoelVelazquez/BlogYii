<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property integer $id_comment
 * @property integer $blog_post_id
 * @property integer $commented_by
 * @property string $comment
 * @property integer $status
 * @property integer $parent
 *
 * @property Posts $blogPost
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_post_id', 'commented_by', 'comment', 'status'], 'required'],
            [['blog_post_id', 'commented_by', 'status', 'parent'], 'integer'],
            [['comment'], 'string'],
            [['blog_post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['blog_post_id' => 'id_post']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_comment' => Yii::t('app', 'Id Comment'),
            'blog_post_id' => Yii::t('app', 'Blog Post ID'),
            'commented_by' => Yii::t('app', 'Commented By'),
            'comment' => Yii::t('app', 'Comment'),
            'status' => Yii::t('app', 'Status'),
            'parent' => Yii::t('app', 'Parent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPost()
    {
        return $this->hasOne(Posts::className(), ['id_post' => 'blog_post_id']);
    }
}
