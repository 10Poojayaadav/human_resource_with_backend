<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {

        $employee = Employee::get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Employee retrieved successfully',
            'data'    => $employee,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees',
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:employees',
            'department'  => 'required|string|max:255',
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        return response()->json($employee);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }
        $validated = $request->validate([
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email,' . $id,
            'department'  => 'required|string|max:255',
        ]);
        $employee->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully'
        ]);
    }
}
