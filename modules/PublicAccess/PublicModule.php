<?php

namespace app\modules\PublicAccess;

/**
 * PublicAccess module definition class
 */
class PublicModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\PublicAccess\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    } // end function


    public function beforeAction($action)
    {
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    } // end function

} // end class
