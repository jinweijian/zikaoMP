<?php

namespace App\Model;

class UserModel extends BaseModel
{
    public $table = 'users';

    public function updateSessionId($userId, $sessionId)
    {
        $update = [
            'session_id' => $sessionId,
        ];

        return $this->update($userId, $update);
    }

    public function findBySessionId($sessionId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE session_id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$sessionId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$username]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function findByUsernameAndPassword($username, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? AND password = SHA1(?)";
        $stmt = $this->pdo()->prepare($sql);
        $res = $stmt->execute([$username, $password]);

        if (!$res) {
            systemLog('error', "login sql error: {$sql}", $stmt->errorInfo());
        }
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function generateRandomSessionId($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

    public function changePassword($userId, $newPassword)
    {
        $sql = "UPDATE {$this->table} SET password = SHA1(?)  WHERE id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$newPassword, $userId]);

        return $stmt->rowCount();
    }
}
