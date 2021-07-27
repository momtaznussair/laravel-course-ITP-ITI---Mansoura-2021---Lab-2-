<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Facebook login authentication
     *
     * @return void
     */
    public function loginWithGoogle()
    {
        try {

            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->first();

            if($user){
                Auth::login($user);
                return redirect('/posts');
            }

            else{
                $createUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'fb_id' => $googleUser->id,
                    'password' => encrypt('test@123')
                ]);

                Auth::login($createUser);
                return redirect('/posts');
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
