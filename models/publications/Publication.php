<?php

namespace app\models\publications;

// project classes
use app\interfaces\PublicationInterface;
use app\models\common\Languages;
// yii classes
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Publication
 * Basic ActiveRecord class for publication models;
 * All other publication models MUST extend current class;
 */
class Publication extends ActiveRecord implements PublicationInterface
{

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return parent::attributeLabels(); // TODO: Change the autogenerated stub
    } // end function


    /**
     * sets flash messages using Alert widget (yii2)
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        // saving language
        $newlanguage = new Languages();
        $newlanguage->language = strtolower($this->language);
        $newlanguage->save();

        if ($this->isNewRecord) {
            if ($insert) {
                Yii::$app->session->setFlash('success', 'Статья сохранена');
                return true;
            } else {
                Yii::$app->session->setFlash('danger', 'Сохранение не удалось');
                return false;
            }
        }

        return true;
    } // end function


    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // saving language
        /*$newlanguage = new Languages();
        $newlanguage->language = strtolower($this->language);
        $newlanguage->save();*/
    } // end function


    /**
     * uses SchemeTrait deleteLinkedData() method
     *
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->deleteLinkedData();
    } // end function


    /**
     * private method returning namespace of child class which uses this trait
     *
     * @return string
     */
    public function getNamespace()
    {
        $current_class = explode('\\', get_called_class());
        array_pop($current_class);
        return implode('\\', $current_class) . '\\';
    } // end function


    /**
     * lists types available for current publication
     * RENAMED - from types();
     *
     * @return array - current namespace Types records
     */
    public function getAvailableTypes()
    {
        $types_class = $this->namespace . 'Types';
        return ArrayHelper::map($types_class::find()->asArray()->all(), 'id', 'type');
    } // end function


    /**
     * gets current unit type value (from Types record)
     * RENAMED - from typeValue();
     *
     * @return string|null
     */
    public function getTypeValue()
    {
        $type_class = $this->namespace . 'Types';
        if (isset($this->type)) {
            return $type_class::find()->select(['type'])->where(['id' => $this->type])->one()->typr;
        }

        return null;
    } // end function


    /**
     * method deletes all linked to current article model records
     * should be used ONLY in afterDelete() method of publication model (!!!)
     *
     * @return void
     */
    public function deleteLinkedData()
    {
        // deleting article pages
        $pages = $this->namespace . 'Pages';
        $pages = new $pages();
        $pages::find()->where(['article_id' => $this->id])->one();
        $pages->delete();

        // deleting authors
        $authors = $this->namespace . 'Authors';
        $authors = new $authors();
        $authors::find()->where(['article_id' => $this->id])->all();
        foreach ($authors as $author) {
            $author->delete();
        }

        // deleting citations
        $citations = $this->namespace . 'Citations';
        $citations = new $citations();
        $citations::find()->where(['article_id' => $this->id])->all();
        foreach ($citations as $citation) {
            $citation->delete();
        }

        // deleting affilations
        $associations = $this->namespace . 'Associations';
        $associations = new $associations();
        $associations::find()->where(['article_id' => $this->id])->all();
        foreach ($associations as $association) {
            $association->delete();
        }
    } // end function


    /**
     * finds Citations linked to current publication
     *
     * @return mixed
     */
    public function getCitations()
    {
        $citation_class = $this->namespace . 'Citations';
        return $this->hasMany($citation_class::className(), ['article_id' => $this->id]);
    } // end function


    /**
     * finds Associations (associated organisations data) linked to current publication
     *
     * @return mixed
     */
    public function getAssociations()
    {
        $association_class = $this->namespace . 'Associations';
        return $this->hasMany($association_class::className(), ['article_id' => $this->id]);
    } // end function

} // end class
