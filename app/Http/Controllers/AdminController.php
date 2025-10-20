<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $sales = Order::where('status', 'completed')->sum('total_amount');
        $earnings = $sales * 0.2; // Assuming 20% profit margin
        $visitors = Customer::count();
        $orders = Order::count();

        $recent_transactions = Order::with('customer')->latest()->take(3)->get();
        $monthly_transactions = Order::with('customer')->latest()->take(4)->get();

        return view('admin.dashboard', compact('sales', 'earnings', 'visitors', 'orders', 'recent_transactions', 'monthly_transactions'));
    }
}
