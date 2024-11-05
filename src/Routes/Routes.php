<?php

use Slim\App;
use App\Controllers\ChatController;

return function (App $app) {
    $app->post('/group', [ChatController::class, 'createGroup']);
    $app->post('/group/{group_id}/join', [ChatController::class, 'joinGroup']);
    $app->post('/group/{group_id}/message', [ChatController::class, 'sendMessage']);
    $app->get('/group/{group_id}/messages', [ChatController::class, 'listMessages']);
    $app->post('/user', [ChatController::class, 'addUser']);
};
