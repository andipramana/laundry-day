<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    private static $search_path = 'employees/search';
    private static $register_form_path = 'employees/register';


    public function showSearch() {
        $data = Employee::all();
        return view(EmployeeController::$search_path, compact('data'));
    }

    public function showRegister() {
        return view(EmployeeController::$register_form_path);
    }

    public function register(Request $request) {
        $data = $request->all();
        $data['employee_code'] = "00000";
        Employee::create($data);

        return redirect()->route('employees');
    }
}
