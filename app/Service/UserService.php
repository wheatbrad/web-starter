<?php declare(strict_types=1);

namespace App\Service;

use App\Auth\SessionManager;
use App\Model\UserModel;

class UserService
{
    public function __construct(
        private SessionManager $sessionManager,
        private UserModel $userModel
    ) {}

    public function authenticate(string $email, $password): bool
    {
        $user = $this->userModel->getUser($email);

        if ($user !== false && password_verify($password, $user->password)) {
            $this->sessionManager->regenerateID();
            $this->sessionManager->set('user', [
                'authenticated' => 1,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ]);
            return true;
        }

        return false;
    }
}