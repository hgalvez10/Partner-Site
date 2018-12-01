<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Partner;
use App\User;
use App\Balance;
use App\Mail\CreateAccount;

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
    protected $redirectTo = '/home';

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
        $validator = Validator::make($data,[
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email',
            'country' => 'required|string|min:3|max:50',
            'city' => 'required|string|min:3|max:50'
        ]);

        if ($validator->fails()) 
        {
            session()->flash('title', '¡Oops!');
            session()->flash('message', 'Encontramos algunos errores!');
            session()->flash('type', 'error');

            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create_partner(Request $data)
    {
        $longitud = 8;
        $pass = substr(MD5(rand(5, 100)), 0, $longitud);

        $user = User::create([
            'name' => mb_strtolower($data['name']),
            'email' => mb_strtolower($data['email']),
            'password' => bcrypt($pass),
            'type' => 2,
            'id_father' => 1
        ]);

        Partner::create([
            'id' => $user['id'],
            'name' => mb_strtolower($data['name']),
            'email' => mb_strtolower($data['email']),
            'income' => 0,
            'country' => mb_strtolower($data['country']),
            'city' => mb_strtolower($data['city']),
            'status' => 'Activo'
        ]);

        Balance::create([
            'funds' => 10000,
            'partner_id' => $user['id']
        ]);

        Mail::to($data['email'])->send(new CreateAccount($user,$pass));

        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado el Partner exitosamente!');
        session()->flash('type', 'success');

        return redirect('/');
    }
}
