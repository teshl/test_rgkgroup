<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 *
 * @property Authors $author
 */
class Books extends \yii\db\ActiveRecord
{
    public $image;

    const PATH_IMG = '/img/books';

    public function getImgDir(){
        return Yii::getAlias('@webroot') . Books::PATH_IMG;
    }

    public function getImgSrc(){
        return Books::PATH_IMG .'/'.$this->preview;
    }

    public function uploadImage()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        if (isset($this->image) ) {
            $this->image->saveAs($this->getImgDir() . '/' . $this->image->name);
            $this->preview = $this->image->name;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],

            [['author_id'], 'required'],
            [['author_id'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => false,
                'targetClass' => Authors::className(),
                'targetAttribute' => ['author_id' => 'id']],

            [['date'], 'required'],
            [['date'], 'date', 'format' => 'php:d/m/Y'],
            [['date'], 'filter', 'filter' => function($value){
                $date = \DateTime::createFromFormat('d/m/Y', $value );
                return date( 'Y-m-d', $date->getTimestamp() );
            }],


            [['image'],'safe'],
            //[['image'],'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Date Update',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
            'image' => 'Изображение книги',
            'authorFullName' => 'ФИО автора'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function getAuthorFullName() {
        return $this->author->firstname . ' ' . $this->author->lastname;
    }
}
