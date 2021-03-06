<?php

namespace app\models\publications\articles\conferences;

use yii\db\ActiveQuery;

/**
 * ActiveQuery class for ArticlePages;
 *
 * @see ArticlePages
 */
class PagesQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Pages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    } // end function


    /**
     * @inheritdoc
     * @return Pages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    } // end function

} // end class
