<?php

namespace app\modules\auth\models\form;

use app\modules\auth\components\UserStatus;
use app\modules\auth\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class ResetPassword extends Model
{
    public $password;
    public $retypePassword;
    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        // check token
        $class = Yii::$app->user->identityClass ?: 'app\modules\auth\models\User';
        if (static::isPasswordResetTokenValid($token)) {
            $this->_user = $class::findOne([
                    'password_reset_token' => $token,
                    'status' => UserStatus::ACTIVE
            ]);
        }
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'retypePassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['retypePassword', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = ArrayHelper::getValue(Yii::$app->params, 'user.passwordResetTokenExpire', 24 * 3600);
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
}
