<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $data= Attendance::with('employee')
            ->latest()
            ->get();
            return response()->json([
            'status'  => 'success',
            'message' => 'Employee retrieved successfully',
            'data'    => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent'
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'date' => $validated['date']
            ],
            [
                'status' => $validated['status']
            ]
        );

        return response()->json([
            'message' => 'Attendance saved successfully',
            'data' => $attendance
        ], 201);
    }

    public function employeeAttendance(Employee $employee)
    {
        return $employee->attendances()->latest()->get();
    }
}
