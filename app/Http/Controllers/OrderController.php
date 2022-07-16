<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private static $search_path = 'pages/orders/search';
    private static $register_form_path = 'pages/orders/register';

    public function showSearch(Request $request) {
        $keywords = $request->input('keywords');
        $data = null;

        if ($keywords == null) {
            $data = Order::all()->sortByDesc('updated_at')->take(100);
        } else {
            $data = Order::where('order_code', 'like', '%' .$keywords. '%')
            ->orWhere('created_at', 'like', '%' .$keywords. '%')
            ->orWhere('weight', 'like', '%' .$keywords. '%')
            ->orWhere('laundry_type', 'like', '%' .$keywords. '%')
            ->orWhere('customer_name', 'like', '%' .$keywords. '%')
            ->orWhere('customer_phone_no', 'like', '%' .$keywords. '%')
            ->orWhere('customer_gender', $keywords)
            ->orWhere('cost', 'like', '%' .$keywords. '%')
            ->orWhere('status', $keywords)
            ->get()
            ->sortByDesc('updated_at')
            ->take(100);
        }

        return view(OrderController::$search_path, compact('data', 'keywords'));
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

    public function createDummy() {
        $begin = new DateTime( "2022-03-24" );
        $end = new DateTime( "2022-06-26" );

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $repeatation = rand(1, 20);
            for ($j=0; $j < $repeatation; $j++) {
                $data['weight'] = rand(1, 15);
                $data['laundry_type'] = rand(1, 2) == 1 ? "regular" : "priority";
                $data['created_at'] = $i;

                $data['order_code'] = OrderController::generateOrderCode();
                $data['date'] = date('Y-m-d');
                $data['status'] = 'Registered';
                $data['cost'] = OrderController::calculateCost($data);

                $data['customer_name'] = (rand(1, 2) == 1 ? "Jhon Doe " : "Jane Doe ").$data['order_code'];
                $data['customer_phone_no'] = 123456789;
                $data['customer_gender'] = rand(1, 2) == 1 ? "Male" : "Female";

                Order::create($data);
            }
        }
    }

    public function findData() {
        $query_date = "DAY(created_at)";
        $query_month = "MONTHNAME(created_at)";
        $query_month_group = $query_month;
        $query_interval_6_day = "6 Day";
        $query_interval_13_day = "13 Day";
        $query_interval_7_day = "7 Day";
        $query_interval_1_year = "1 Year";

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if($driver == 'pgsql') {
            $query_date = "created_at::date";
            $query_month = "TO_CHAR(created_at, 'Month')";
            $query_month_group = $query_month.", TO_CHAR(created_at, 'MM')";
            $query_interval_6_day = "'6 days'";
            $query_interval_13_day = "'13 days'";
            $query_interval_7_day = "'7 days'";
            $query_interval_1_year = "'1 Year'";
        }

        $thisWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw($query_date." as date"))
        ->whereRaw("created_at > current_date - interval ".$query_interval_6_day)
        ->groupBy(DB::raw($query_date))
        ->orderBy(DB::raw($query_date))
        ->pluck('count', 'date');

        $lastWeek = Order::select(DB::raw("COUNT(*) as count"), DB::raw($query_date." as date"))
        ->whereRaw("created_at between current_date - interval ".$query_interval_13_day." and current_date - interval ".$query_interval_7_day)
        ->groupBy(DB::raw($query_date))
        ->orderBy(DB::raw($query_date))
        ->pluck('count', 'date');

        $thisYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw($query_month." as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw($query_month_group))
        ->orderBy(DB::raw($query_month_group))
        ->pluck('cost', 'month_name');

        $lastYear = Order::select(DB::raw("SUM(cost) as cost"), DB::raw($query_month." as month_name"))
        ->whereRaw("created_at <= current_date - interval ".$query_interval_1_year)
        ->groupBy(DB::raw($query_month_group))
        ->orderBy(DB::raw($query_month_group))
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
