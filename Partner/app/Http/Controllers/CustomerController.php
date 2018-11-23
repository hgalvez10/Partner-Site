<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\User;
use App\Contact;
use App\Action;
use App\Order;
use Carbon\Carbon;
use App\Domain;
use App\AuxContact;

class CustomerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function storeAction(Request $request)
    {
        $data_domain = [
            'domainName' => mb_strtolower($request->domain).'.cl',
            'period' => mb_strtolower($request->period),
            'ns' => mb_strtolower($request->nameserver),
            'registrant' => mb_strtolower($request->registrant_id),
            'admin' => mb_strtolower($request->admin_id),
            'billing' => mb_strtolower($request->billing_id),
            'tech' => mb_strtolower($request->tech_id),
            'authinfo' => 'haulmer-'.''.uniqid(),
        ];

        $json_dataDomain = json_encode($data_domain);

        $data_request_action = [
            'entity' => 'domain',
            'action' => 'create',
            'data' => json_decode($json_dataDomain)
        ];

        $json_request_action = json_encode($data_request_action);
        
        // CREAR ORDEN
        $id_orden = Order::create([
            'domainName'  => mb_strtolower($request->domain).'.cl',
            'customer_id' => auth()->user()->id,
            'price'       => 1000,
            'status'      => 'Pendiente'
        ]);

        Action::create([
            'request'     => $json_request_action,
            'status'      => 'Por Hacer',
            'partner_id'  => auth()->user()->id_father,
            'customer_id' => auth()->user()->id,
            'order_id'    => $id_orden['id']
        ]);

        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado la solicitud exitosamente!');
        session()->flash('type', 'success');

        return redirect('/buyDomain');

    }

    public function buyDomain()
    {
        $usercontact = Contact::where('email',"=",auth()->user()->email)->get();
        //dd($usercontact[0]);
        $contact = "cid-".auth()->user()->id;
        return view('partner-site',compact('contact'));
    }

    public function checkDomain(Request $request)
    {
        $domain = $request['domain'].'.cl';
    	$client = new Client(['base_uri' => 'http://127.0.0.1:5000/api/v1.0/registrar/checkDomain/']);
    	$response = $client->request('GET', $domain);
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
            'org' => 'required|string|min:3|max:50',
            'street' => 'required|string|min:3|max:50',
            'city' => 'required|string|min:3|max:50',
            'sp' => 'required|string|min:3|max:50',
            'voice' => 'required|string|min:3|max:50',
            'email' => 'required|email'
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
            'org' => mb_strtolower($request->org),
            'street' => mb_strtolower($request->street),
            'city' => mb_strtolower($request->city),
            'sp' => mb_strtolower($request->sp),
            'voice' => mb_strtolower($request->voice),
            'email' => mb_strtolower($request->email),
            'status' => 'Inactivo'
        ]);

        //CREAR CONTACT EN DB
        $new_contact = Contact::create([
            'id' => "cid".'-'.$user['id'],
            'name' => mb_strtolower($request->name),
            'org' => mb_strtolower($request->org),
            'street' => mb_strtolower($request->street),
            'city' => mb_strtolower($request->city),
            'sp' => mb_strtolower($request->sp),
            'cc' => 'cl',
            'voice' => mb_strtolower($request->voice),
            'email' => mb_strtolower($request->email),
            'authinfo' => 'haulmer-'.''.uniqid()
        ]);

        //dd(json_decode($new_contact));
        $contact = [
            'id' => "cid".'-'.$user['id'],
            'name' => mb_strtolower($request->name),
            'org' => mb_strtolower($request->org),
            'street' => mb_strtolower($request->street),
            'city' => mb_strtolower($request->city),
            'sp' => mb_strtolower($request->sp),
            'cc' => 'cl',
            'voice' => '+56.'.''.mb_strtolower($request->voice),
            'email' => mb_strtolower($request->email),
            'authinfo' => 'haulmer-'.''.uniqid()
        ];

        $client = new \GuzzleHttp\Client;
        $options = [
            'body' => json_encode($contact),
            'headers' => ['Content-Type' => 'application/json'],
        ];
        $client->post('http://127.0.0.1:5000/api/v1.0/registrar/createContact/', $options);
        //dd($json);

        // VER si se hace correctamente para retornar mensaje de error o de registro
        session()->flash('title', '¡Éxito!');
        session()->flash('message', 'Se ha registrado el Cliente exitosamente!');
        session()->flash('type', 'success');

        return redirect('/customer/create');
    }

    public function getDomains()
    {
        $usercontact = DB::table('contacts')
                            ->where('email','=', auth()->user()->email)
                            ->get();

        $domains = DB::table('domains')
                        ->where('registrant_id', '=', $usercontact[0]->id)
                        ->get();

        $nameCustomer = auth()->user()->name;
        return view('domains-all', compact('domains', 'nameCustomer'));
    }

    public function getOrders()
    {
        $orders = DB::table('orders')
                            ->where('customer_id','=', auth()->user()->id)
                            ->get();

        return view('orders-all', compact('orders'));
    }

    public function getDomainsByCustomer(Customer $customer)
    {
        //dd($customer);
        $usercontact = DB::table('contacts')
                            ->where('email','=', $customer->email)
                            ->get();

        $domains = DB::table('domains')
                        ->where('registrant_id', '=', $usercontact[0]->id)
                        ->get();

        $nameCustomer = auth()->user()->name;
        return view('domains-all', compact('domains', 'nameCustomer'));
    }

    public function renewDomain(Request $request, $id)
    {
       
        $domain = Domain::find($id);
        $name_domain = $domain->domainName;
        $exp_date = Carbon::parse($domain->expirate_date)->format('Y-m-d');
        //dd($exp_date);
        $domain_data = [
            'domainName'=>$name_domain,
            'period'=>$request->period,
            'exDate'=> $exp_date
        ];

        $client = new \GuzzleHttp\Client;
        $options = [
            'body' => json_encode($domain_data),
            'headers' => ['Content-Type' => 'application/json'],
        ];
        $response  = $client->post('http://127.0.0.1:5000/api/v1.0/registrar/renewDomain/', $options);

        $json = (array)json_decode($response->getBody());
        //dd($json);

        if ($json['Code'] == 1000) {
            
            $domain->expirate_date = $json['Expiration Date'];
            $domain->save();

            session()->flash('title', '¡Éxito!');
            session()->flash('message', 'el dominio se ha renovado exitosamente!');
            session()->flash('type', 'success');

            return redirect('/myDomains');
        }
       
        session()->flash('title', '¡Error!');
        session()->flash('message', 'Upss dominio no renovado!');
        session()->flash('type', 'danger');

        return redirect('/myDomains');

    }

    public function createContact(Request $request)
    {
        $admin_contact = AuxContact::create([
            'email' => $request['email'],
            'owner' => auth()->user()->id
        ]);


        $contact = [
            'id' => "coc".'-'.$admin_contact['id'],
            'name' => mb_strtolower($request['name']),
            'org' => mb_strtolower($request['org']),
            'street' => mb_strtolower($request['street']),
            'city' => mb_strtolower($request['city']),
            'sp' => mb_strtolower($request['region']),
            'cc' => 'cl',
            'voice' => '+56.'.''.mb_strtolower($request['voice']),
            'email' => mb_strtolower($request['email']),
            'authinfo' => 'haulmer-'.''.uniqid()
        ];

        $client = new \GuzzleHttp\Client;
        $options = [
            'body' => json_encode($contact),
            'headers' => ['Content-Type' => 'application/json'],
        ];

        $response = $client->post('http://127.0.0.1:5000/api/v1.0/registrar/createContact/', $options);
        
        $json = (array)json_decode($response->getBody());

        if ($json['Code'] == 1000)
        {
            $new_contact = Contact::create([
                'id' => "coc".'-'.$admin_contact['id'],
                'name' => mb_strtolower($request['name']),
                'org' => mb_strtolower($request['org']),
                'street' => mb_strtolower($request['street']),
                'city' => mb_strtolower($request['city']),
                'sp' => mb_strtolower($request['region']),
                'cc' => 'cl',
                'voice' => '+56.'.''.mb_strtolower($request['voice']),
                'email' => mb_strtolower($request['email']),
                'authinfo' => 'haulmer-'.''.uniqid()
            ]);

            return response()->json(array('response' => true, 'id' => $contact['id']));

        }
        return response()->json(array('response' => false));

    }
       
        
}
