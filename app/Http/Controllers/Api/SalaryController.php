<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function paid(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'salary_month' => 'required',
        ]);

        $month = $request->salary_month;
        $check = Salary::where('employee_id', $id)->where('salary_month', $month)->first();
        if ($check) {
            return response()->json('Already paid this month salary');
        } else {
            Salary::insert([
                'employee_id'  => $id,
                'ammount'      => $request->salary,
                'salary_date'  => date('d/m/Y'),
                'salary_month' => $month,
                'salary_year'  => date('Y'),
            ]);
        }
    }

    public function index()
    {
        $salary = Salary::select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salary);
    }

    public function viewSalary($id)
    {
        $view = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'salaries.*')
            ->where('salaries.salary_month', $id)
            ->get();
        return response()->json($view);
    }

    public function editSalary($id)
    {
        $view = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'employees.email', 'salaries.*')
            ->where('salaries.id', $id)
            ->first();
        return response()->json($view);
    }
    public function updateSalary(Request $request, $id)
    {
        Salary::where('id', $id)->update([
            'employee_id'  => $request->employee_id,
            'salary_month' => $request->salary_month,
            'ammount'      => $request->ammount,
        ]);
    }
}
