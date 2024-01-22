<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        $user && Log::create(['type' => Log::USER_LOGIN, 'user_id' => $user->id]);

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $user = Auth::user();

        $user && Log::create(['type' => Log::USER_LOGOUT, 'user_id' => $user->id]);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
