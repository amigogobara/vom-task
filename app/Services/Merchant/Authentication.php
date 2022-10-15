<?php

namespace App\Services\Merchant;

use App\Http\Requests\RegisterRequest;
use App\Models\Store;
use App\Models\User;

class Authentication
{
    public function register(RegisterRequest $request)
    {
        $user = $this->createUser($request->validated());
        $this->createStore($request->validated(), $user);

        $token = auth()->tokenById($user->id);

        return ['user' => $user,'token' => $token];
    }

    private function createUser($validatedData)
    {
        return User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => 1
        ]);
    }

    private function createStore($validatedData, $user)
    {
        $store = Store::create([
            'name' => $validatedData['store_name'],
            'url'  => $validatedData['store_url']
        ]);

        $user->update(['store_id' => $store->id]);
    }
}
