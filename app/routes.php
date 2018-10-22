<?php

$app->get('/', App\Controllers\HomeController::class .':accueil');


$app->group('/auth', function () {

    $this->post('/login', App\Controllers\AuthController::class .':login');

    $this->post('/logout', App\Controllers\AuthController::class .':logout');

});


$app->group('/chat', function () {

    $this->post('/listeusers', App\Controllers\ChatController::class .':listAllUsers');

    $this->post('/listedatainitadmin', App\Controllers\ChatController::class .':listedatainitadmin');

    $this->post('/addmembre', App\Controllers\ChatController::class .':addmembre');

    $this->post('/getrole', App\Controllers\ChatController::class .':getrole');


    $this->post('/listemessagesroom', App\Controllers\ChatController::class .':listAllMessagesRoom');

    $this->post('/envoimessageroom', App\Controllers\ChatController::class .':envoimessageroom');

    $this->post('/envoifileroom', App\Controllers\ChatController::class .':envoifileroom');


    $this->post('/getgroupe', App\Controllers\ChatController::class .':getgroupe');

    $this->post('/listemessagesgroupe', App\Controllers\ChatController::class .':listAllMessagesGroupe');

    $this->post('/envoimessagegroupe', App\Controllers\ChatController::class .':envoimessagegroupe');

    $this->post('/envoifilegroupe', App\Controllers\ChatController::class .':envoifilegroupe');


    $this->post('/getuser', App\Controllers\ChatController::class .':getuser');

    $this->post('/listemessagesuser', App\Controllers\ChatController::class .':listAllMessagesUser');

    $this->post('/envoimessageuser', App\Controllers\ChatController::class .':envoimessageuser');

    $this->post('/envoifileuser', App\Controllers\ChatController::class .':envoifileuser');

});

$app->group('/user', function () {

    $this->post('/addmembre', App\Controllers\UserController::class .':addmembre');

});

$app->group('/file', function () {

    $this->post('/onUploadfile', App\Controllers\UploadController::class .':onUploadfile');

    //$this->get('/showfile', App\Controllers\UploadController::class .':showfile');
    $this->get('/showfile/{file}', App\Controllers\UploadController::class .':showfile');
    //$this->post('/showfile', App\Controllers\UploadController::class .':showfile');

});

