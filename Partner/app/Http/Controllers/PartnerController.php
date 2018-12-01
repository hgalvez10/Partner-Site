<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Partner;
use App\User;
use App\Balance;
use App\Transaction;
use App\Mail\CreateAccount;


class PartnerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
    	$partners = Partner::All();

    	return view('admin.partner.index', compact('partners'));
    }

    public function create()
    {
    	return view('admin.partner.create');
    }

    public function viewRegister()
    {
        return view('admin.partner.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
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

            return redirect('/partner/create')
                ->withErrors($validator)
                ->withInput();
        }
        $longitud = 8;
        $pass = substr(MD5(rand(5, 100)), 0, $longitud);
        $user = User::create([
            'name' => mb_strtolower($request->name),
            'email' => mb_strtolower($request->email),
            'password' => bcrypt($pass),
            'type' => 2,
            'id_father' => auth()->user()->id
        ]);

        Partner::create([
            'id' => $user['id'],
            'name' => mb_strtolower($request->name),
            'email' => mb_strtolower($request->email),
            'income' => 0,
            'country' => mb_strtolower($request->country),
            'city' => mb_strtolower($request->city),
            'status' => 'Activo'
        ]);

        Balance::create([
            'funds' => 10000,
            'partner_id' => $user['id']
        ]);

        Mail::to($request['email'])->send(new CreateAccount($user,$pass));

        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado el Partner exitosamente!');
        session()->flash('type', 'success');

        return redirect('/partner/create');
    }

    public function createPartnerAccount(array $data)
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

    public function getTransactions()
    {
        $transactions = DB::table('transactions')
                            ->where('partner_id','=', auth()->user()->id)
                            ->get();

        return view('transactions-all', compact('transactions'));
    }

    public function balance()
    {
        $balance = DB::table('balances')
                                ->where('partner_id','=',auth()->user()->id)
                                ->get();

        $balance_available = $balance[0]->funds;

        $partnerBD = DB::table('partners')
                                ->where('id', '=', auth()->user()->id)
                                ->get();

        $partner = $partnerBD[0];
        $address = $partnerBD[0]->city.', '.$partnerBD[0]->country;

        return view('balance-partner', compact('balance_available', 'partner', 'address'));
    }

    public function addFunds(Request $request)
    {
        $balance = DB::table('balances')
                            ->where('partner_id', auth()->user()->id)
                            ->increment('funds', $request->balance);

        $transaction = Transaction::create([
            'description' => 'Cargo de fondos a tu cuenta.',
            'partner_id' => auth()->user()->id,
            'customer_id' => 0,
            'balance' => $request->balance
        ]);

        return redirect('/mytransactions');
    }
}
