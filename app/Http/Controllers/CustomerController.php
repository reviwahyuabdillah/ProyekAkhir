<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ambil semua data last lalu bagi menjadi 5 data setiap page
        $customer =  Customer::latest()->paginate(5);
        // kembalikan halaman view customer list dengan mengirim datanya
        return view('customer_list',compact('customer'))
        ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //tampilkan halaman add customer
        return view('customer_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            // menjalankan fungsi insert pada table customer 
            Customer::create($request->all());
            // redirect ke halaman list customer
            return redirect()->route('customer.index')->with('success','Successfully to create new customer');
        } catch (\Throwable $th) {
            //throw $th;
           // munculkan pesan error jika ada error
            return redirect()->route('customer.index')->with('error',$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //munculkan data customer sesuai parameter id dan ambil satu data
        $customer =  Customer::where('customer_id',$id)->firstOrFail();
        // jika ada data customer
        if($customer){
            // buka halaman view customer_edit dengan mengirim datanya
            return view('customer_edit',compact('customer'));
        }else{
            return redirect()->route('customer.index')->with('error','Customer not found');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //tambahkan validasi
        //ambil data customer sesuai parameter id dan lakukan update pada modelnya
        Customer::where('customer_id',$id)->update([
            'fullname'=> $request->fullname,
            'email'=> $request->email,
            'gender'=> $request->gender,
            'address'=> $request->address

        ]);


        return redirect()->route('customer.index')->with('success','Successfully update data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //lakukan delete pada data customer sesuai parameter id
        Customer::where('customer_id',$id)->delete();

        return redirect()->route('customer.index')->with('success','Successfully delete data');
    }

    public function getCustomerById(Request $request){
       
      //ajax akan meminta request untuk mengambil data customer berdasarkan parameter
        $customer =  Customer::where('customer_id',$request->id)->firstOrFail();
        // kembalikan data dalam bentuk response json
        return response()->json([
            'customer'=>$customer
        ]);
     }
}