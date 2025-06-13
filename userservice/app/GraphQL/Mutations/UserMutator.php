<?php
// File: app/GraphQL/Mutations/UserMutator.php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserMutator
{
    /**
     * Membuat user baru dengan password yang di-hash.
     *
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($_, array $args): User
    {
        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']), // Enkripsi password di sini
        ]);
    }
}