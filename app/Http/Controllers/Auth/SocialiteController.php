<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
// use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialiteController extends Controller
{
    /**
 * @var SocialiteFactory $socialite
 */

    public function redirectToProvider($provider)
{
    $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    return response()->json(['url' => $url]);
}

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

        // Generate a personal access token for API authentication
        $token = $user->createToken('SocialiteLogin')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Authentication failed'], 500);
    }
}

}
