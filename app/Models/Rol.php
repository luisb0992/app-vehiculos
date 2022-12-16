<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'roles';

    protected $fillable = [
        'name',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
