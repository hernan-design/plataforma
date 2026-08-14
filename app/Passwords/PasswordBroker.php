<?php

namespace App\Passwords;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;

use SendEmail, TuProyecto;

class PasswordBroker extends \Illuminate\Auth\Passwords\PasswordBroker
{
      /**
     * Determine if the passwords are valid for the request.
     *
     * @param  array  $credentials
     * @return bool
     */
    protected function validatePasswordWithDefaults(array $credentials)
    {
        list($password, $confirm) = [
            $credentials['password'],
            $credentials['password_confirmation'],
        ];

        return $password === $confirm && mb_strlen($password) >= 4;
    }

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    public function sendResetLink(array $credentials, Closure $callback = null)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return static::INVALID_USER;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        // $user->sendPasswordResetNotification(
            // $this->tokens->create($user)
        // );

        $token = $this->tokens->create($user);

        // Mail reminder;
        $data['_template'] = 'emails.auth.password';

        // Send Mail
        $data['_subject'] = trans('passwords.mail.subject');
        $data['_to'] = strtolower(trim($user->correo_electronico));
        $data['_to_name'] = $user->nombre_usuario;

        $data['token'] = $token;
        $data['email'] = strtolower(trim($user->correo_electronico));
        SendEmail::notification($data);

        return static::RESET_LINK_SENT;
    }
}
