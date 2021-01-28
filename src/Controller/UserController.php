<?php

namespace App\Controller;

use App\Model\User;
use App\Traits\Auth;
use App\Exception\ValidationException;

class UserController
{
    public function index()
    {
        $users = User::getAll();

        $data = [
            'title' => 'Users',
            'users' => $users
        ];
        return view('user.user_list', $data);
    }

    /**
     * @return string
     * @throws ValidationException
     */
    public function registration(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'User registration',
            ];
            return view('user.user_registration', $data);
        }

        $errors = [];
        $data = $_POST;
        if (empty($data['email'])) {
            $errors['email'] = 'Cannot be empty';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Cannot be empty';
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        echo 'Registration ok';
        return '';
    }
}