<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
        'username', 'password', 'fullname','profile_image' ,'email', 'token', 'last_login'
    ];

    protected $returnType = \App\Entities\User::class;
    public $rules = [
        'email' => 'required|valid_email',
        'username' => 'required|alpha_numeric|min_length[5]|is_unique[users.username]',
        'password' => 'required|min_length[8]',
        'confirmation' => 'required_with[password]|matches[password]',
        'fullname' => 'required|min_length[5]',
    ];

    public $loginRules = [
        'username' => 'required',
        'password' => 'required'
    ];

    public function addUser($data)
    {
        $user = new \App\Entities\User();
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->fullname = $data['fullname'];
        $this->save($user);
        return [$user->username, $this->getInsertID()];
    }

    public function login($username, $password)
    {
        $user = $this->where('username', $username)->first();
        if($user && password_verify($password, $user->password)){
            return [$user->username, $user->id];
        } else {
            return false;
        }
    }
    
}