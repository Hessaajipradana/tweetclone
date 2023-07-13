<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \App\Models\UserModel;
use \App\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        # $2y$10$WhI4kzkQ6bky6EtCboe3JOt/GivGPPJxsDY56wbBV7Lgy2B932QHS -> testingpassword
        $data = [
            [
                "id"       => 1,
                "username" => "cakjas",
                "password" => 'testingpassword',
                "fullname" => "Cakrawala Jasmani Maryadi S.E."
            ],
            [
                "id"       => 2,
                "username" => "karmana",
                "password" => 'testingpassword',
                "fullname" => "Karma Najmudin"
            ],
            [
                "id"       => 3,
                "username" => "opbanget",
                "password" => 'testingpassword',
                "fullname" => "Ophelia Ana Zulaika S.Kom"
            ],
            [
                "id"       => 4,
                "username" => "gabbyva",
                "password" => 'testingpassword',
                "fullname" => "Gabriella Vanesa Melani M.M."
            ],
            [
                "id"       => 5,
                "username" => "samhab",
                "password" => 'testingpassword',
                "fullname" => "Samsul Habibi"
            ],
            [
                "id"       => 6,
                "username" => "betindah",
                "password" => 'testingpassword',
                "fullname" => "Betania Indah Rahimah S.E."
            ],
            [
                "id"       => 7,
                "username" => "indragun",
                "password" => 'testingpassword',
                "fullname" => "Indra Gunarto S.Farm"
            ],
            [
                "id"       => 8,
                "username" => "ratnashak",
                "password" => 'testingpassword',
                "fullname" => "Ratna Shakila Utami S.Farm"
            ],
            [
                "id"       => 9,
                "username" => "gadangsuw",
                "password" => 'testingpassword',
                "fullname" => "Gadang Suwarno"
            ],
            [
                "id"       => 10,
                "username" => "olihas",
                "password" => 'testingpassword',
                "fullname" => "Oliva Hasna Suartini S.E.I"
            ],
        ];
        
        $userMdl = new UserModel();
        foreach($data as $user){
            $userMdl->addUser($user);
        }
    }
}
