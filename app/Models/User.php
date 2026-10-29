<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = ['username', 'password', 'role'];

    protected $hidden = ['password'];

    // password otomatis di-hash saat diisi
    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    // tabel lama tidak punya kolom remember_token
    public function getRememberTokenName()
    {
        return '';
    }
}