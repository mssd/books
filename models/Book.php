<?php

namespace app\models;

use Yii;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $name
 * @property string $preview
 * @property string $date_release
 * @property string $date_create
 * @property string $date_update
 */
class Book extends \yii\db\ActiveRecord
{
    /**
    * Дата создания книги
    */
    public function getCreate()
    {
        $sToday = date('Y-m-d');
        $sYesterday = date('Y-m-d', time()-86000);
        switch($this->date_create)
        {
            default:
                return Yii::$app->formatter->asDate($this->date_create, 'd MMMM Y');
                break;

            case $sToday:
                return 'Сегодня';
                break;

            case $sYesterday:
                return 'Вчера';
                break;
        }
    }

    /**
    * Дата выхода книги
    */
    public function getRelease()
    {
        return Yii::$app->formatter->asDate($this->date_release, 'd MMMM Y');
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'name', 'date_release'], 'required'],
            [['author_id'], 'integer'],
            [['date_release', 'date_create', 'date_update'], 'safe'],
            [['name'], 'string', 'max' => 500],
            [['preview'], 'file', 'extensions' => 'jpg, gif, png', 'skipOnEmpty' => false],
            [['preview'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'name' => 'Название',
            'preview' => 'Превью',
            'date_release' => 'Дата выхода книги',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
