<?php

namespace App\Factories;
use App\Models\User;

class UserFactory
{
  public function createUser(array $data) : User
  {
    //dd($data);
    return User::create([
        'name' => $data['name'],
        'last_name' => $data['last_name'],
        'rol_id' => $data['rol_id'],
        'email' => $data['email'],
        'dni' => $data['dni'],
        'password' => $data['password'],
        'workshop_id' => $data['workshop_id'],
      ]);
  }
}
