<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\ChatModel;

class ChatController {
    private $chatModel;

    public function __construct() {
        $this->chatModel = new ChatModel();
    }

    public function createGroup(Request $request, Response $response) {
        // Parse JSON body
        $data = json_decode($request->getBody()->getContents(), true);
    
        if (empty($data['name'])) {
            $response->getBody()->write(json_encode(['error' => 'Group name is required']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    
        // Call createGroup in ChatModel and retrieve the created group ID
        $groupId = $this->chatModel->createGroup($data['name']);
    
        // Return success status with the created group ID
        $response->getBody()->write(json_encode(['status' => 'Group created', 'group_id' => $groupId]));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    

    public function joinGroup(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $this->chatModel->joinGroup($args['group_id'], $data['user_id']);
        $response->getBody()->write(json_encode(['status' => 'Joined group']));
        //$response->getBody()->write("status: Joined group, 'user with user_id' => " . $data['user_id'] . ", 'joined the group with group_id' => " . $args['group_id']);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function sendMessage(Request $request, Response $response, $args) {
       
        // Manually parse JSON body as an alternative
        $data = json_decode($request->getBody()->getContents(), true);
    
        // Debugging to verify parsed body contents
        error_log(print_r($data, true));
        
        $this->chatModel->sendMessage($args['group_id'], $data['user_id'], $data['message']);
        $response->getBody()->write(json_encode(['status' => 'Message sent']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function listMessages(Request $request, Response $response, $args) {
        $groupId = $args['group_id'];
    
        // Fetch messages for the specified group
        $messages = $this->chatModel->listMessages($groupId);
        $response->getBody()->write(json_encode($messages));
    
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    public function addUser(Request $request, Response $response) {
         // Manually parse JSON body as an alternative
         $data = json_decode($request->getBody()->getContents(), true);
    
         // Debugging to verify parsed body contents
         error_log(print_r($data, true));
     
         if (empty($data['username'])) {
             $response->getBody()->write(json_encode(['error' => 'Group name is required']));
             return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
         }

        $userId = $this->chatModel->addUser($data['username']);
       

         // Return success status with the created group ID
         $response->getBody()->write(json_encode(['status' => 'User added', 'user_id' => $userId]));
         return $response->withHeader('Content-Type', 'application/json');
    }
    
}
