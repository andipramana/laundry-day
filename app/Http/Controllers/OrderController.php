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
        $data = Order::all()->sortByDesc('updated_at')->take(100);
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

    public function findData() {
        $thisWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw("created_at::date as date"))
        ->whereRaw("created_at > current_date - interval '6 days'")
        ->groupBy(DB::raw("created_at::date"))
        ->orderBy(DB::raw('created_at::date'))
        ->pluck('count', 'date');

        $lastWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw("created_at::date as date"))
        ->whereRaw("created_at between current_date - interval '13 days' and current_date - interval '7 days'")
        ->groupBy(DB::raw("created_at::date"))
        ->orderBy(DB::raw('created_at::date'))
        ->pluck('count', 'date');

        $thisYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw("TO_CHAR(created_at, 'Month') as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("TO_CHAR(created_at, 'Month'), TO_CHAR(created_at, 'MM')"))
        ->orderBy(DB::raw("TO_CHAR(created_at, 'Month'), TO_CHAR(created_at, 'MM')"))
        ->pluck('cost', 'month_name');

        $lastYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw("TO_CHAR(created_at, 'Month') as month_name"))
        ->whereRaw("created_at <= current_date - interval '1 Year'")
        ->groupBy(DB::raw("TO_CHAR(created_at, 'Month'), TO_CHAR(created_at, 'MM')"))
        ->orderBy(DB::raw("TO_CHAR(created_at, 'Month'), TO_CHAR(created_at, 'MM')"))
        ->pluck('cost', 'month_name');

        $totalOrderThisWeek = OrderController::sumTotalOrder($thisWeek);
        $totalOrderLastWeek = OrderController::sumTotalOrder($lastWeek);
        $growthThisWeek = 0;
        if ($totalOrderLastWeek > 0) {
            $growthThisWeek = ($totalOrderThisWeek - $totalOrderLastWeek) / $totalOrderLastWeek * 100;
        }

        $totalOrderThisYear = OrderController::sumTotalOrder($thisYear);
        $totalOrderLastYear = OrderController::sumTotalOrder($lastYear);
        $growthThisYear = 0;
        if ($totalOrderLastYear > 0) {
            $growthThisYear = ($totalOrderThisYear - $totalOrderLastYear) / $totalOrderLastYear * 100;
        }

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
