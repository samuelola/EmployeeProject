<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Library\Utilities;
use App\Jobs\ProcessEmployee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::orderByDesc('created_at')->get();
        return Utilities::sendResponse(EmployeeResource::collection($employees), 'Employee retrieved successfully.');
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {

        $employee_data = $request->validated();
        $newEmployee = new Employee;
        $newEmployee->project_id = $employee_data['project_id'];
        $newEmployee->name = $employee_data['name'];
        $newEmployee->email = $employee_data['email'];
        $newEmployee->position = $employee_data['position'];
        $newEmployee->save();
        ProcessEmployee::dispatch($newEmployee);
        return Utilities::sendResponse(new EmployeeResource($newEmployee), 'Employee Data saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $find_employee = Employee::where('id',$id)->orderByDesc('created_at')->first();
         if (is_null($find_employee )) {
            return Utilities::sendError('Employee not found.');
        }else{
             return Utilities::sendResponse(new ProductResource($find_employee), 'Employee retrieved successfully.');
        }
    }

   
    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $find_employee = Employee::where('id',$id)->orderByDesc('created_at')->first();
        if (is_null($find_employee)) {
            return Utilities::sendError('Employee not found.');
        }else{
           $employee_data = $request->validated();
           $find_employee->update($product_data);
           return Utilities::sendResponse($find_employee, 'Employee Updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return Utilities::sendResponse('Deleted','Employee Deleted successfully.');
    }

    public function restoreData(string $employee_id){
        $employee = Employee::withTrashed()->find($employee_id)->restore();
        return Utilities::sendResponse($employee, 'Employee Restored successfully.');
    }
}
