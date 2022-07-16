<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    private static $search_path = 'pages/employees/search';
    private static $register_form_path = 'pages/employees/register';
    private static $modify_form_path = 'pages/employees/modify';

    public function showSearch(Request $request) {
        $keywords = $request->input('keywords');
        $data = null;

        if ($keywords == null) {
            $data = Employee::all();
        } else {
            $data = Employee::where('name', 'like', '%' .$keywords. '%')
            ->orWhere('phone_no', 'like', '%' .$keywords. '%')
            ->orWhere('employee_code', 'like', '%' .$keywords. '%')
            ->orWhere('gender', $keywords)
            ->get();
        }

        return view(EmployeeController::$search_path, compact('data', 'keywords'));
    }

    public function showRegister() {
        return view(EmployeeController::$register_form_path);
    }

    public function register(Request $request) {
        $data = $request->all();
        $data['employee_code'] = EmployeeController::generateEmployeeCode();
        Employee::create($data);

        return redirect()->route('employees');
    }

    public function showModify($id) {
        $employee = Employee::find($id);
        return view(EmployeeController::$modify_form_path, compact('employee'));
    }

    public function modify(Request $request) {
        Employee::where('id', $request->id)
        ->update([
            'employee_code' => $request->employee_code,
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'gender' => $request->gender
        ]);

        return redirect()->route('employees');
    }

    public function delete($id) {
        Employee::where('id', $id)->delete();

        return redirect()->route('employees');
    }

    private function generateEmployeeCode() {
        $employee_code = '';
        $total_employee = Employee::count();
        $total_employee = strval($total_employee + 1);

        if ($total_employee < 10) {
            $employee_code = '000'.$total_employee;
        } else if ($total_employee < 100) {
            $employee_code = '00'.$total_employee;
        } else if ($total_employee < 1000) {
            $employee_code = '0'.$total_employee;
        } else {
            $employee_code = $total_employee;
        }

        return $employee_code;
    }
}
