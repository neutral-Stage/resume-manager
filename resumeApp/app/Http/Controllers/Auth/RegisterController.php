<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\NotificationsController;
use App\User;
use App\Http\Controllers\Controller;
use App\UserData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
        protected $redirectTo = '/freelancer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|alpha_dash|string|min:6|unique:users',
            'profession' => 'required',
            'englishLevel' => 'accepted'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'username'=>$data['username'],
            'profession'=>$data['profession'],
            'password' => Hash::make($data['password']),
        ]);

        $user = User::where('username',$data['username'])->first();
        $userData = new UserData;
        $userData->user_id = $user->id;
        $userData->name = $user->name;
        $userData->save();
        // send admins email when freelancer registers.
        $notification = new NotificationsController();
        $notification->freelancerRegisteredEmail($data);
        $notification->freelancerWelcomeEmail($data);

        return $user;
    }

}
