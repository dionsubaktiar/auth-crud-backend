<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        try {
            // Generate the redirect URL for the provider
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to generate redirect URL'], 500);
        }
    }

    public function handleProviderCallback($provider)
    {
        try {
            // Retrieve user info from the provider
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

            // Generate a personal access token for the authenticated user
            $token = $user->createToken('SocialiteLogin')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
    }
}
