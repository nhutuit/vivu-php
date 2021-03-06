<?php

namespace common\models;

use Yii;
use \common\core\web\mvc\BaseModel;


/**
 * @property integer $id
 * @property string $name
 * @property integer $priority
 * @property string $notes
 * @property string $url_key
 * @property string $meta_desc
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $category_group_id
 * @property string $cover_image_path
 */
class Category extends BaseModel
{
    public static function tableName()
    {
        return 'vv.category';
    }

    public function rules()
    {
        return [
            [['name', 'priority', 'url_key'], 'required'],
            [['url_key'],'unique'],
            [['name', 'notes', 'url_key', 'meta_desc', 'cover_image_path'], 'string'],
            [['priority', 'status', 'created_by', 'updated_by', 'category_group_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryGroup::className(), 'targetAttribute' => ['category_group_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        $attrs = [
            'name' => Yii::t('app', 'Name'),
            'priority' => Yii::t('app', 'Priority'),
            'notes' => Yii::t('app', 'Notes'),
            'url_key' => Yii::t('app', 'Url Key'),
            'meta_desc' => Yii::t('app', 'Meta Desc'),
            'category_group_id' => Yii::t('app', 'Category Group'),
            'cover_image_path' => Yii::t('app', 'Cover Image Path'),
        ];
        return array_merge($attrs, parent::attributeLabels());
    }
}
