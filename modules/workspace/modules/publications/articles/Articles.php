<?php

namespace app\modules\workspace\modules\publications\articles;

use yii\base\Module;

/**
 * articles module definition class
 */
class Articles extends Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\workspace\modules\publications\articles\controllers';
    //public $defaultRoute = 'app\modules\Control\modules\articles\controllers\JournalsController';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    } // end function

} // end class
