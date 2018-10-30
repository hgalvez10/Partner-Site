<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class CustomerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function buyDomain()
    {
        return view('partner-site');
    }

    public function checkDomain(Request $request)
    {
    	$client = new Client(['base_uri' => 'http://127.0.0.1:5000/api/v1.0/registrar/checkDomain/']);
    	$response = $client->request('GET', $request['domain']);
    	$json = (array)json_decode($response->getBody());

    	if ($json['Available'] == true) {
    		return response()->json(array('response' => true));
    	}
    	else
    	{
    		return response()->json(array('response' => false ));
    	}
    }

    public function index()
    {
    	$customers = Customer::All();

    	return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
    	return view('admin.customer.create');
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

            return redirect('/customer/create')
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::create([
            'name' => mb_strtolower($request->name),
            'email' => mb_strtolower($request->email),
            'password' => Hash::make('123456'),
            'type' => 3,
            'id_father' => auth()->user()->id
        ]);

        Customer::create([
        	'id' => $user['id'],
            'name' => mb_strtolower($request->name),
            'email' => mb_strtolower($request->email),
            'country' => mb_strtolower($request->country),
            'city' => mb_strtolower($request->city),
            'status' => 'Inactivo'
        ]);

        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado el Cliente exitosamente!');
        session()->flash('type', 'success');

        return redirect('/customer/create');
    }
}
