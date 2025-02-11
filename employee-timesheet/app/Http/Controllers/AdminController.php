<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function getEmployees(Request $request)
    {
        $query = User::where('role_id', '2');
        
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%'); 
        }
    
        $employees = $query->get();
        return response()->json($employees);
    }
    

    public function getTimesheets(Request $request)
    {
        $employeeName = $request->get('employee_name');
        $date = $request->get('date');
    
        $timesheets = Timesheet::with('user') 
            ->when($employeeName, function ($query) use ($employeeName) {
                return $query->whereHas('user', function ($userQuery) use ($employeeName) {
                    $userQuery->where('name', 'LIKE', "%{$employeeName}%");
                });
            })
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->get();
    
        return response()->json($timesheets);
    }
    
}
