<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));
        
        if (!$user) {
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Invalid verification link.',
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with([
                'status' => 'success',
                'message' => 'Email sudah diverifikasi sebelumnya.',
            ]);
        }

        // Verify the hash
        if (!hash_equals(sha1($user->getEmailForVerification()), $request->route('hash'))) {
            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Invalid verification link.',
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('login')->with([
            'status' => 'success',
            'message' => 'Email berhasil diverifikasi. Silakan login untuk melanjutkan.',
        ]);
    }
}
