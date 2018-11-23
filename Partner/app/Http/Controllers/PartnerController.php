<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Partner;
use App\User;
use App\Balance;


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
        $user = User::create([
            'name' => mb_strtolower($request->name),
            'email' => mb_strtolower($request->email),
            'password' => Hash::make('123456'),
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


        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado el Partner exitosamente!');
        session()->flash('type', 'success');

        return redirect('/partner/create');
    }

    public function getTransactions()
    {
        $transactions = DB::table('transactions')
                            ->where('partner_id','=', auth()->user()->id)
                            ->get();

        return view('transactions-all', compact('transactions'));
    }
}
