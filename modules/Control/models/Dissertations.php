<?php

namespace app\modules\Control\models;

use Yii;

/**
 * This is the model class for table "dissertations".
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property int $author_id
 * @property int $date
 * @property string $code
 * @property string $organisation
 * @property string $speciality
 * @property string $type
 * @property string $opponents
 * @property string $annotation
 */
class Dissertations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dissertations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author'], 'required'],
            [['author_id', 'date'], 'integer'],
            [['opponents', 'annotation'], 'string'],
            [['title', 'author', 'code', 'organisation', 'speciality', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'author' => 'Автор',
            'author_id' => 'Author ID',
            'date' => 'Дата защиты',
            'code' => 'Шифр диссертационного совета',
            'organisation' => 'Организация',
            'speciality' => 'Специальность',
            'type' => 'Тип диссертации',
            'opponents' => 'Оппоненты',
            'annotation' => 'Аннотация',
        ];
    }

    /**
     * @inheritdoc
     * @return DissertationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DissertationsQuery(get_called_class());
    }
}