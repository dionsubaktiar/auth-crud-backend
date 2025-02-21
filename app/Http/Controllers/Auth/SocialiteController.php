<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the authentication page of the provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->stateless()->redirect();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to redirect to the provider.'], 500);
        }
    }

    /**
     * Handle the provider callback.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            // Find or create the user in the database
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]
            );

            // Generate token
            $token = $user->createToken('SocialiteLogin')->plainTextToken;

            // Redirect back to the frontend with the token
            $frontendUrl = 'https://dionsubaktiar.vercel.app/auth-crud/callback';
            return redirect()->to("{$frontendUrl}?token={$token}");
        } catch (\Exception $e) {
            Log::error('Socialite login error: ' . $e->getMessage());
            return redirect()->to('https://dionsubaktiar.vercel.app/auth-crud/login?error=oauth_failed');
        }
    }

}
