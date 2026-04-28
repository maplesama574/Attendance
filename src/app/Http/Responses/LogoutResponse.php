<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        if ($user->is_admin) {
            return redirect('/admin/attendance/login');
        }

        return redirect('/login');
    }
}