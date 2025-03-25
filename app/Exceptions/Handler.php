<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;


class Handler extends Exception
{

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $guard = Arr::get($exception->guards(), 0);

        return match ($guard) {
            'admin' => redirect()->route('admin.login'),
            'company' => redirect()->route('company.login'),
            default => redirect()->guest(route('login')),
        };
    }}
