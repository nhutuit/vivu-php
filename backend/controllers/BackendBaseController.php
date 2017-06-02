<?php
/**
 * CreatedBy: thangcest2@gmail.com
 * Date: 6/10/16
 * Time: 9:31 AM
 */

namespace backend\controllers;

use backend\business\BusinessOrder;
use Yii;
use common\controllers\CommonBaseController;
use common\modules\adminUser\business\BusinessAdminUser;
use common\Factory;
use common\utilities\Common;
use yii\helpers\Url;

class BackendBaseController extends CommonBaseController
{
    public function init()
    {
        if (isset(Factory::$app->request->cookies['language'])) {
            Factory::$app->language = Factory::$app->request->cookies['language']->value;
        } else {
            Factory::$app->language = 'en';
        }
        $params = Common::getStatusArr();
        $this->addJsParams([
            'textActionStatus' => $params,
            'STATUS_DELETE' => STATUS_DELETED,
            'STATUS_HIDE' => STATUS_HIDE,
            'STATUS_ACTIVE' => STATUS_ACTIVE,
            'messages' => Factory::$app->getAppMessages(),
            'urlHome' => Url::home(),
            'APP_ENV' => YII_ENV,
            'countOrder' => BusinessOrder::getInstance()->getCount()
        ]);
        parent::init();
    }

    public function beforeAction($action)
    {
        if ($this->action->id == 'login') {
            return parent::beforeAction($action);
        }

        if (Factory::$app->user->isGuest) {
            Factory::$app->response->redirect(['site/login'])->send();
            exit;
        }

        $permission = BusinessAdminUser::getPermission();
        if (!$permission) {
            flassError(\Yii::t('app', 'You are not allowed to perform this action.'));
            Factory::$app->response->redirect(['site/index'])->send();
            exit;
        }
        $headers = Factory::$app->request->headers;
        if (isset($headers['viewinmodal'])) {
            $this->layout = false;
        }

        return parent::beforeAction($action);
    }

}
