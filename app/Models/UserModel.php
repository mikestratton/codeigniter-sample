<?php

namespace App\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';

    protected $allowedFields = [
        'name',
        'email',
        'password'
    ];

    protected $returnType = 'App\Entities\User';

    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email|is_unique[user.email]',
        'password' => 'required|min_length[8]',
        'password_confirmation' => 'required|matches[password]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'That email address is already taken'
        ],
        'password_confirmation' => [
            'required' => 'Please confirm your password',
            'matches' => 'Please enter the same password again',
        ]
    ];

    protected $beforeInsert = ['hashPassword'];

    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if(isset($data['data']['password'])){
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }

        return $data;
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)
            ->first();
    }

    public function disablePasswordValidation()
    {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }
}