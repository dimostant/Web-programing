<?php

namespace App\Http\Controllers;

use App\Models\customers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = DB::table('customers')->get();
        $url = $_SERVER['REQUEST_URI'];

        if ($url == '/form/edit') { 
            return view("Customers.customers", compact('customers'));
        }
        if ($url == '/form/soz') {
            return view("Customers.create")->with('message', 'We are sorry!');//not working
        }
        if ($url == '/form') {
            return view("Customers.create");
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('customers')->insert([
            'email' => $request->get('floating_email'),
            'firstname' => $request->get('floating_first_name'),
            'lastname' => $request->get('floating_last_name'),
            'phone_number' => $request->get('floating_phone'),
            'company' => $request->get('floating_company') 
        ]);
        return view("Customers.create");
    }

    /**
     * Display the specified resource.
     */
    public function show(customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customers::find($id);

        return view("Customers.edit", compact("customer"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // dd ($request, $id);
        $customer = Customers::find($id);
        $customer->where('id', $id)->update([
                    'email' => $request->get('floating_email'),
                    'firstname' => $request->get('floating_first_name'),
                    'lastname' => $request->get('floating_last_name'),
                    'phone_number' => $request->get('floating_phone'),
                    'company' => $request->get('floating_company')             
                ]);

     return redirect()->route('form.editall')->with('success','Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customers::find($id);

        $customer->delete();

        return redirect()->route('form.editall')->with('success','Customer deleted successfully');
    }
}
