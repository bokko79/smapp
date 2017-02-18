<?php
namespace common\models;

use Yii;
use yii\base\Model;
use dektrium\user\models\LoginForm as DektriumLoginForm;

/**
 * Login form
 */
class LoginForm extends DektriumLoginForm
{
    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            //$this->user->updateAttributes(['last_login_at' => time()]);
            return Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        }

        return false;
    }
}
