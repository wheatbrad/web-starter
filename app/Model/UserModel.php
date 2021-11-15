<?php declare(strict_types=1);

namespace App\Model;

use PDO;

class UserModel
{
    public function __construct(private PDO $pdo) {}

    public function getUser(string $email): object|false
    {
        $stmt = $this->pdo->prepare('SELECT `id`, `first_name`, `last_name`, `password` FROM `user` WHERE `email` = ?');
        $stmt->execute([$email]);
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}