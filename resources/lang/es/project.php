<?php

return array(
    'project' => 'Emprendimiento|Emprendimientos',
    'unauth.comment' => '¿Quieres saber más sobre este emprendimiento?',

    'error.title' => 'Ya existe un emprendimiento con este titulo asociado, <a href=":url">Ver</a>.',
    
    //send mail Entrepreneurship
    'mail.create.subject' => 'Has creado un emprendimiento',
    'mail.create.body' => '¡Felicitaciones! Has creado tu emprendimiento.
        <br/><br/>
        Recuerda que la información siempre estará disponible y podrás editarla en “Tu Cuenta”,
        haciendo click en la pestaña “Emprendimientos”.
        <br/><br/>
        <a href=":url_proyecto">Ver Emprendimiento</a>
        <br/><br/>
        También puedes compartir tu emprendimiento en el muro de la comunidad y en otras redes.
        <br/><br/>
        Si con este emprendimiento quieres participar en algún programa, visita la sección
        <a href=":url_call">Programas</a>. ',

    //send mail Idea
    'mail.create.idea.subject' => 'Has creado una idea',
    'mail.create.idea.body' => '
        ¡Felicitaciones! Has creado tu idea en la red.
        <br/><br/>
        Recuerda que la información siempre estará disponible y podrás editarla en “Tu Cuenta”,
        haciendo click en la pestaña “Emprendimientos”.
        <br/><br/>
        <a href=":url_proyecto">Ver Idea</a>
        <br/><br/>
        También puedes compartir tu idea en el muro de la comunidad y en otras redes.
        <br/><br/>
        Si con esta idea quieres participar en algún programa, visita la sección <a href=":url_call">Programas</a>.',
    
    //send mail Group   
    'mail.create.group.subject' => 'Has creado un grupo',
    'mail.create.group.body' => '¡Felicitaciones! Has creado un grupo.
        <br/><br/>
        Recuerda que la información siempre estará disponible y podrás editarla en “Tu Cuenta”,
        haciendo click en la pestaña “Emprendimientos”.
        <br/><br/>
        <a href=":url_proyecto">Ver Grupo</a>
        <br/><br/>
        Puedes compartir tu grupo en el muro de la comunidad y en otras redes. ',

    //send mail Company       
    'mail.create.company.subject' => 'Has creado una emprensa',
    'mail.create.company.body' => '
        ¡Felicitaciones! Has creado tu empresa en la red. 
        <br/><br/>
        Recuerda que la información siempre estará disponible y podrás editarla en “Tu Cuenta”, haciendo click en la pestaña “Emprendimientos”.
        <br/><br/>
        <a href=":url_proyecto">Ver Empresa</a>
        <br/><br/>
        También puedes compartir tu empresa en el muro de la comunidad y en otras redes.
        <br/><br/>
        Si con este emprendimiento quieres participar en algún programa, visita la sección
        <a href=":url_call">Programas</a>
        .',    
              
	'mail.create.view' => 'Ver emprendimiento',
    'mail.create.idea.view' => 'Ver Idea',
    'mail.create.group.view' => 'Ver Grupo',
    'mail.create.company.view' => 'Ver Empresa',

    'mail.group.project.subject' => 'te han invitado a ser parte de la empresa/proyecto :entity',
    'mail.group.project.body' => 'Te han invitado a ser  parte del equipo de la empresa/proyecto.',
    'mail.group.project.confirm' => 'Has clic en el siguiente enlace para confirmar.',
    
    'group.success' => 'Se ha enviado la invitación a :user (:mail) para ser parte de tu empresa/proyecto. Será oficialmente miembro de tu empresa/proyecto cuando acepte tu invitación.',

    'mail.comment.subject' => ':user también comentó el proyecto de :owner.‏',
	'mail.comment.subject.owner' => ':user comentó tu emprendimiento.‏',
    'mail.comment.body' => 'también comentó el emprendimiento.',
    'mail.comment.body.owner' => 'comentó tu emprendimiento.‏',
	'mail.comment.view' => 'Ver comentarios',

    'new.project' => 'Nuevo Emprendimiento',
    'new.company' => 'Nueva Empresa',
    'new.group' => 'Nuevo Grupo',
    'new.idea' => 'Nueva Idea',

    'class.idea' => 'Idea',
    'class.entrepreneurship' => 'Emprendimiento',
    'class.group' => 'Grupo',
    'class.company' => 'Empresa',
    
    'close.confirm' => 'Recuerda: Una vez eliminado la información no podrá ser recuperada.'
);

