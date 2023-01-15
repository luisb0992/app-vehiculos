<?php

namespace App\Factories;
use App\Models\User;

class UserFactory
{
  public function createUser(array $data) : User
  {
    return User::create([
        'name' => $data['name'],
        'last_name' => $data['last_name'],
        'rol_id' => $data['rol_id'],
        'email' => $data['email'],
        'dni' => $data['dni'],
        'password' => $data['password'],
        'workshop_id' => $data['workshop_id'] ?? null,
      ]);
  }

  public function updateUser(array $data,$user)
  {
    $user->name = $data['name'];
    $user->last_name = $data['last_name'];
    $user->rol_id = $data['rol_id'];
    $user->email = $data['email'];
    $user->dni = $data['dni'];
    $user->workshop_id = $data['workshop_id'];

    if(isset($data['password'])){
      $user->password = $data['password'];
    }

    return $user->save();

  }

  public function getUsersWithRelationShip(){

    return User::with('rol','workshop')->where('id','!=',auth()->user()->id)->orderBy('id', 'DESC')->get();
  }

  public function getUsers(){
    return User::where('id','!=',auth()->user()->id)->orderBy('id', 'DESC')->get();
  }

  public function getUsersWithRol($rol_id){
    return User::where('rol_id',$rol_id)->orderBy('id', 'DESC')->get();
  }

  public function findUserWithId($id)
  {
    return User::find($id);
  }
}
