<?php

Scrn::$hostname = 'scrn.tk';

date_default_timezone_set('Europe/Moscow');
header("Content-Type: text/html; charset=utf8");

Http_Auth::$conf['dev'] = function() {
    $dsn = new Http_Auth_Dsn();
    $dsn->title = 'Developers Only Area';
    $dsn->salt = '<random-string>';
    $dsn->users = array(
        '<login>'  => '<password-hash>', // use Http_Auth::makeHash($login, $password, $salt);
    );
    return $dsn;
};

Http_Client::$conf['default'] = function () {
    $r = new Http_Client_Dsn('file-get-contents');
    //$r->proxy = 'tcp://localhost:8118';
    return $r;
};

Log::$conf['default'] = 'stdout';
Log::$conf['update'] = 'file:///processed.log';
Log::$conf['processing'] = 'file:///processed.log';
Log::$conf['error'] = 'file:///error.log';

Storage::$conf['debug_log'] = 'php-var';

Database::$conf['default'] = 'mysqli://scrn:scrn@localhost/scrn?charset=utf8&timezone=Europe/Moscow';
App::db()->log(Log::getInstance(Log_Dsn::create('storage://localhost/?storage=debug_log')));

if (App::MODE_CLI == App::instance()->mode) {
    App::db()->log(new Log('stdout'));
}
