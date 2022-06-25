<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private static $search_path = 'orders/search';
    private static $register_form_path = 'orders/register';

    public function showSearch() {
        $data = Order::all();
        return view(OrderController::$search_path, compact('data'));
    }

    public function showRegister() {
        return view(OrderController::$register_form_path);
    }

    public function register(Request $request) {
        $data = $request->all();
        $data['order_code'] = OrderController::generateOrderCode();
        $data['date'] = date('Y-m-d');
        $data['status'] = 'Registered';
        $data['cost'] = OrderController::calculateCost($data);

        Order::create($data);

        return redirect()->route('orders');
    }

    public function process(Request $request) {
        Order::where('order_code', $request->code)->update(['status' => $request->status]);

        return redirect()->route('orders');
    }

    private function generateOrderCode() {
        $order_code = '';
        $current_date = date('Ymd');
        $todays_order = Order::where('date', $current_date)->count();

        if ($todays_order < 10) {
            $order_code = strval($current_date).'000'.strval($todays_order);
        } else if ($todays_order < 100) {
            $order_code = strval($current_date).'00'.strval($todays_order);
        } else if ($todays_order < 1000) {
            $order_code = strval($current_date).'0'.strval($todays_order);
        } else {
            $order_code = strval($current_date).strval($todays_order);
        }

        return $order_code;
    }

    private function calculateCost(Array $data) {
        if($data['laundry_type'] == 'regular') {
            return $data['weight'] * 6000;
        } else {
            return $data['weight'] * 8000;
        }
    }
}
