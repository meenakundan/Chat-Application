<?php

namespace App\Models;

use PDO;

class ChatModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createGroup($name) {
        $stmt = $this->pdo->prepare('INSERT INTO groups (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
    
        // Return the last inserted ID (group ID)
        return $this->pdo->lastInsertId();
    }
    

    public function addUser($username) {
        $stmt = $this->pdo->prepare('INSERT INTO users (username) VALUES (:username)');
        $stmt->execute(['username' => $username]);
        return $this->pdo->lastInsertId();
    }

    public function joinGroup($groupId, $userId) {
        $stmt = $this->pdo->prepare('INSERT OR IGNORE INTO group_users (group_id, user_id) VALUES (:group_id, :user_id)');
        $stmt->execute(['group_id' => $groupId, 'user_id' => $userId]);
    }

    public function sendMessage($groupId, $userId, $message) {
        $stmt = $this->pdo->prepare('INSERT INTO messages (group_id, user_id, message) VALUES (:group_id, :user_id, :message)');
        $stmt->execute(['group_id' => $groupId, 'user_id' => $userId, 'message' => $message]);
    }

    public function getMessages($groupId) {
        $stmt = $this->pdo->prepare('SELECT * FROM messages WHERE group_id = :group_id ORDER BY timestamp');
        $stmt->execute(['group_id' => $groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listMessages($groupId) {
        $stmt = $this->pdo->prepare('
            SELECT messages.id, messages.message, messages.timestamp, users.username 
            FROM messages 
            JOIN users ON messages.user_id = users.id 
            WHERE messages.group_id = :group_id 
            ORDER BY messages.timestamp
        ');
        $stmt->execute(['group_id' => $groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
