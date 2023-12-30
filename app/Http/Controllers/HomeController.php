<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $customerCount = Customer::count();
        $orderCount = Order::count();

        return view('dashboard', compact('bookCount', 'customerCount', 'orderCount'));
    }
}