<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(){
        $user = Socialite::driver('google')->stateless()->user();
        $registeredUser = User::where('email', $user->email)->first();

        if(!$registeredUser){
            $user = User::updateOrCreate([
                'id' => $user->id,
            ],[
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('1234'),
                'nip' => '999999999999999',
                'pangkat' => 'IV/a',
                'unit_kerja' => '8010',
                'jabatan' => '90',
                'is_aktif' => false,
                'is_admin' => false,
                'is_sekma' => false,
                'is_sekwil' => false,
                'is_perencana' => false,
                'is_apkapbn' => false,
                'is_opwil' => false,
                'is_analissdm' => false
            ]);

            Auth::login($user);
            return redirect()->route('dashboard');
        }
        Auth::login($registeredUser);
        return redirect()->route('dashboard');
    }
    public function handleProvideCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        $user = Socialite::driver('google')->user();
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, 'google');
        // login user
        if($authUser !== NULL){
            Auth()->login($authUser, true);
        }else{
            return redirect()->route('login')
                    ->with('status', 'Akun belum terdaftar, silahkan hubungi admin')
                    ->with('alert-type', 'danger');
        }

        // setelah login redirect ke dashboard
        return redirect()->route('dashboard');
    }
    // get avatar from socialite


    public function findOrCreateUser($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        return $user;
        // Get Social Account
        // $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
        //     ->where('provider_name', $provider)
        //     ->first();
        // // return $socialAccount->user;


        // // Jika sudah ada
        // if ($socialAccount) {
        //     // return user
        //     return $socialAccount->user;

        //     // Jika belum ada
        // } else {

        //     // User berdasarkan email
        //     $user = User::where('email', $socialUser->getEmail())->first();

        //     // Jika Tidak ada user
        //     if (!$user) {
        //         // Create user baru
        //         $user = User::create([
        //             'name'  => $socialUser->getName(),
        //             'email' => $socialUser->getEmail()
        //         ]);
        //     }

        //     // Buat Social Account baru
        //     $user->socialAccounts()->create([
        //         'provider_id'   => $socialUser->getId(),
        //         'provider_name' => $provider
        //     ]);

        //     // return user
        //     return $user;
        // }
    }
}
