<?php

namespace app\modules\Control\models;

/**
 * This is the ActiveQuery class for [[Messages]].
 *
 * @see Messages
 */
class MessagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Messages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Messages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}