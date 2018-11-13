<?php

namespace app\modules\workspace\modules\Admin;

use Yii;
use yii\base\Module;

/**
 * admin module definition class
 */
class Admin extends Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\workspace\modules\Admin\controllers';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //\Yii::configure($this, []);

    } // end function



    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\console\Response|\yii\web\Response
     */
    public function beforeAction($action)
    {

        if(!\Yii::$app->access->isAdmin()) {
            return \Yii::$app->getResponse()->redirect('/workspace?denyrequest=1');
        }

        Yii::$app->telemetry->whoami()->save();

        return true;

    } // end function

} // end class
