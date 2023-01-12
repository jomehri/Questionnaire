<?php

namespace App\Http\Requests\Api;

use App\Models\Basic\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized with given permission
     *
     * @param string $permission
     * @return bool
     */
    public function authorizeUserRole(string $permission): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->hasRole($permission);
    }


}
