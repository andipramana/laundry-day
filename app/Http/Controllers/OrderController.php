<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private static $search_path = 'pages/orders/search';
    private static $register_form_path = 'pages/orders/register';

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

    public function findData(Request $request) {
        $thisWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw("DAY(created_at) as date"))
        ->whereRaw('created_at > current_date - interval 6 Day')
        ->groupBy(DB::raw("DAY(created_at)"))
        ->orderBy('created_at')
        ->pluck('count', 'date');

        $lastWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw("DAY(created_at) as date"))
        ->whereRaw('created_at between current_date - interval 13 day and current_date - interval 6 day')
        ->groupBy(DB::raw("DAY(created_at)"))
        ->orderBy('created_at')
        ->pluck('count', 'date');

        $thisYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("MONTHNAME(created_at)"))
        ->orderBy('created_at')
        ->pluck('cost', 'month_name');

        $lastYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y') - 1)
        ->groupBy(DB::raw("MONTHNAME(created_at)"))
        ->orderBy('created_at')
        ->pluck('cost', 'month_name');

        $totalOrderThisWeek = OrderController::sumTotalOrder($thisWeek);
        $totalOrderLastWeek = OrderController::sumTotalOrder($lastWeek);;
        $growthThisWeek = ($totalOrderThisWeek - $totalOrderLastWeek) / $totalOrderLastWeek * 100;

        $totalOrderThisYear = OrderController::sumTotalOrder($thisYear);
        $totalOrderLastYear = OrderController::sumTotalOrder($lastYear);
        $growthThisYear = ($totalOrderThisYear - $totalOrderLastYear) / $totalOrderLastYear * 100;

        return [
            'thisWeek' => ['keys' => $thisWeek->keys(), 'values' => $thisWeek->values()],
            'lastWeek' => ['keys' => $lastWeek->keys(), 'values' => $lastWeek->values()],
            'thisYear' => ['keys' => $thisYear->keys(), 'values' => $thisYear->values()],
            'lastYear' => ['keys' => $lastYear->keys(), 'values' => $lastYear->values()],
            'totalOrderThisWeek' => $totalOrderThisWeek,
            'totalOrderLastWeek' => $totalOrderLastWeek,
            'growthThisWeek' =>  number_format($growthThisWeek, 2),
            'totalOrderThisYear' => $totalOrderThisYear,
            'totalOrderLastYear' => $totalOrderLastYear,
            'growthThisYear' =>  number_format($growthThisYear, 2)
        ];
    }

    private function sumTotalOrder(Collection $order) {
        $total = 0;
        foreach ($order as $value) {
            $total += (float) $value;
        }

        return $total;
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
