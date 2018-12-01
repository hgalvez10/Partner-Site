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
use GuzzleHttp\Client;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('whoIs');
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
        $customerCount = Customer::count();

        $type_user = auth()->user()->type;

        if ($type_user == 2) 
        {
            $balance = DB::table('balances')
                                ->where('partner_id','=',auth()->user()->id)
                                ->get();

            $balance_available = $balance[0]->funds;

            $customerCount = DB::table('users')
                                        ->where('id_father','=',auth()->user()->id)
                                        ->count();

            $customers = DB::table('users')->where('id_father','=',auth()->user()->id)->get();

            $domainsCount = 0;
            foreach ($customers as $customer) {
                $usercontact = DB::table('contacts')
                            ->where('email','=',$customer->email)
                            ->get();

                $domainsCount = $domainsCount + DB::table('domains')
                        ->where('registrant_id', '=', $usercontact[0]->id)
                        ->get()->count();

            }
            $domainCount = $domainsCount;
        }
        if ($type_user == 3) 
        {
            return redirect('/myDomains');
        }
        else
        {
            return view('admin', compact('domainCount', 'partnerCount', 'customerCount', 'balance_available'));
        }
    }

    public function all_Domains()
    {

        $type_user = auth()->user()->type;

        if ($type_user == 2) 
        {
            $customers = DB::table('users')->where('id_father','=',auth()->user()->id)->get();

            $domains = array();

            foreach ($customers as $customer) {
                $usercontact = DB::table('contacts')
                            ->where('email','=',$customer->email)
                            ->get();

                $domainscustomers = DB::table('domains')
                        ->where('registrant_id', '=', $usercontact[0]->id)
                        ->get();
                foreach ($domainscustomers as $domain) {
                    array_push($domains, $domain);
                }
            }
            $domainCount = count($domains);
        }
        if($type_user == 1)
        {
            $domains = Domain::All();
            $domainCount = $domains->count();
        }

        return view('domains-all', compact('domains','domainCount'));
    }

    public function whoIs(Request $request)
    {

        if(str_contains($request['domainWhois'], '.cl'))
        {
            $domain = $request['domainWhois'];
            $client = new Client(['base_uri' => 'http://127.0.0.1:5000/api/v1.0/registrar/whois/']);
            $response = $client->request('GET', $domain);
            $json = (array)json_decode($response->getBody());
        
            if($json['Response'] === "Error") 
            {
                return response()->json(array('response' => false));
            }
            else
            {
                //buscar datos
                $json_response = (array)$json['Response'];
                $id_registrant = $json_response['Registrant'];
                $userContact = DB::table('contacts')
                                    ->where('id','=', $id_registrant)
                                    ->get();

                
                //dd($json_response);
                if (!$userContact->isEmpty()) {
                    $data_toView = [
                        'registrant'   => $userContact[0]->name,
                        'registry'     => 'Haulmer Inc.',
                        'created_date' => $json_response['Created at date'],
                        'exp_date'     => $json_response['Expiration Date']
                    ];
                }
                else
                {
                    $data_toView = [
                        'registrant'   => 'No encontrado en nuestros registros.',
                        'registry'     => 'No identificado',
                        'created_date' => $json_response['Created at date'],
                        'exp_date'     => $json_response['Expiration Date']
                    ];
                }
                

                return response()->json(array('response' => true, 
                                              'registrant_name' => $data_toView['registrant'],
                                              'registry_name' => $data_toView['registry'],
                                              'created_date' => $data_toView['created_date'],
                                              'exp_date' => $data_toView['exp_date'],
                                              'domainName' => $domain
                ));
            }
        }
        return response()->json(array('response' => false));

    }
}
