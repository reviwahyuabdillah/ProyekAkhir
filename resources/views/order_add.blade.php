@extends('adminlte::page')

@section('css')
<style>
      .imgUpload {
                max-width: 300px;
                max-height: 300px;
                min-width: 300px;
                min-height: 300px;
            }

        .select2-container{
        width: 1120.74px;
        border: 1px solid #ccc!important;
        padding: 5px;
        
    }
</style>

@section('title', 'New Order')
@section('content_header')
    <h1>Create a New Order</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Order Id</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="order_id" id="order_id" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Order Date</label>
                                <div class="col-sm-10">
                                    @php
                                    $config = ['format' => 'YYYY-MM-DD'];
                                    $date = date('Y-m-d');
                                    @endphp
                                    <x-adminlte-input-date name="order_date" value="{{ $date }}" :config="$config"/>
                                    
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Customer</label>
                                <div class="col-sm-10">
                                    <x-adminlte-select2 name="customer_id" id="customer">
                                        <option value="" disabled selected>Please Choose Customer ...</option>
                                        @foreach ($customer as $c)
                                            
                                            <option value="{{ $c->customer_id}}">{{ $c->fullname }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    
                                </div>
                            </div>
                          
                           
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Book</label>
                                <div class="col-sm-10">
                                    <x-adminlte-select2 name="book_id" id="book">
                                        <option value="" disabled selected>Please Choose Book ...</option>
                                        @foreach ($book as $b)
                                            
                                            <option value="{{ $b->book_id}}">{{ $b->title }}</option>
                                        @endforeach
                                    
                                    </x-adminlte-select2>
                                    
                                </div>
                            </div>
                          
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Email </label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control"  id="email"
                                    readonly
                                    >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Price Rp.</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="price" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Quantity </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="quantity" id="quantity">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Total </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="total" id="total" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Amount </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="amount" id="amount">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Payment Status </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="payment_status" id="payment_status">  
                                </div>
                            </div>
                            
            
                           
                        
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i>
                                     Save</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('js')
<script>

// fungsi ajax yaitu memanggil url,method,type, dan success
// ketika url mengakses API order.getOrderId dengan metode get
// jika success maka akan mengembalikan response dari json
   $.ajax({
    url:`{{ route('order.getOrderId') }}`,
    method:'get',
    type:'application/json',
    success:function(response){
    // buat variabel key dari response.key
        var key =  response.key
    // isi value yang ada di input order_id
        $('#order_id').val(key)
        console.log(response)
    }
   })

// ketika kita memilih customer event ini berjalan
   $('#customer').change(function (){
// ambil value data customer
// ambil id pada data customer
    var customer  = $(this).val();
  // buat ajax untuk mengambil email dari customer yang di pilih
        $.ajax({
            url:`{{ route('customer.getCustomerById') }}`,
            method:'get',
            data:{id:$('#customer').val()},
        
            success:function(response){
              // jika berhasil ambil data response.customer.email
               var email =  response.customer.email;
              // isi value dari input email
               $('#email').val(email);
            }
        })
    });
  
  // ketika buku di pilih maka events berjalan
   $('#book').change(function (){
   // ambil value buku
    var book  = $(this).val();
    // buat ajax untuk mengambil harga dari buku yang di pilih
        $.ajax({
            url:`{{ route('book.getPriceById') }}`,
            method:'get',
            data:{id:$('#book').val()},
        
            success:function(response){
              // simpan response price dalam variabel price
                var price =  response.book.price
               //  isi value pada input price
                $('#price').val(price); 
            }
        })
    });
  
  // ketika kita isi angka quantity maka event akan berjalan
    $('#quantity').keyup(function (){
      // ambil value quantity nya
        var quantity = $(this).val()
      // ambil value price
        var  price = $('#price').val()
      // buat variabel awal nama total=0
        var total = 0
       // rumus nya quantity * price
        total = quantity * price;   
        // munculkan value total hasil dari rumus diatas
        $('#total').val(total)

     })

// ketika kita isi angka amount maka event akan berjalan
     $('#amount').keyup(function (){
      // ambil data amount dan convert ke integer
        var amount =  parseInt($(this).val())
       // ambil data total dan convert ke integer
        var total = parseInt($('#total').val())
        // jika amount = total maka status paid selainnya status unpaid
        if(amount === total ){
            $('#payment_status').val('Paid')
        }
        else if(amount <=total){
            $('#payment_status').val('Unpaid')
        }
      })
</script>
@stop