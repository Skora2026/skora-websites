<?php
 namespace App\Http\Responses;
 use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
 use Symfony\Component\HttpFoundation\Response;
 class LoginResponse implements LoginResponseContract
 {
    public function toResponse($request): Response
    {
        $role = $request->user()->role;
        return match($role) {
            'admin' => redirect()->intended('/admin-dashboard'),
            'user' => redirect()->intended('/'),
             default => redirect()->intended('/'),
        };
    }
 }