<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reminder Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'password' => 'La contraseña debe contener al menos una mayúscula (A - Z), una minúscula (a - z), un dígito (0 - 9) y un carácter especial, el cual puede ser $¡!#.@:%_-*+~=¿?()<>',
    'reset' => 'La contraseña se ha restablecido!',
    'sent' => 'Hemos enviado por correo electrónico el enlace para restablecer contraseña!',
    'token' => 'Este token de restablecimiento de contraseña no es válido.',
    'user' => "No podemos encontrar un usuario con ese e-mail.",

    'mail.subject' => 'Restablecer contraseña',
    'mail.body' => 'Recientemente, alguien solicitó cambiar la contraseña de tu cuenta. Si fuiste tú, haz clic en el siguiente enlace para definir una nueva contraseña.',
    'mail.view' => 'Restaurar contraseña',
    'mail.expire' => 'Este enlace expirará en :minutes minutos.',
    'mail.alert' => 'Si no deseas modificar tu contraseña o no solicitaste hacerlo, ignora y elimina este mensaje. <br/>Para preservar la seguridad de tu cuenta, no reenvíes este mensaje a nadie.',

    'change' => 'Cambiar contraseña ',
    'title' => '¿Olvidaste tu contraseña? | No puedo iniciar sesión',
    'description' => 'Podemos ayudarte a restablecer tu contraseña.'
];
