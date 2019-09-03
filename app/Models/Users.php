<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Users extends Model implements Authenticatable
{
   //
   use AuthenticableTrait;

   protected $table = 'users';

   protected $fillable = ['full_name','email','password'];
   protected $hidden = [
   'password'
   ];
}