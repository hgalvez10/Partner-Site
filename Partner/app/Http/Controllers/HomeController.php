<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Domain;
use App\Partner;
use App\Customer;
use App\Balance;
use App\User;
use App\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $domainCount = Domain::count();
        $partnerCount = Partner::count();
        $customerCount = Customer::count();//$clientes = User::where('id_father',"=",auth()->user()->id)->get();
            //dd($clientes);

        $type_user = auth()->user()->type;

        if ($type_user == 2) 
        {
            $balance = DB::table('balances')
                                ->where('partner_id','=',auth()->user()->id)
                                ->get();

            $balance_available = $balance[0]->funds;
        }

        return view('admin', compact('domainCount', 'partnerCount', 'customerCount', 'balance_available'));
    }

    public function all_Domains()
    {

        $domains = Domain::All();
        $domainCount = $domains->count();

        return view('domains-all', compact('domains','domainCount'));
    }
}
