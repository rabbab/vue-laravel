<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Declare a global variable with relation orders!
        $employee =  Employee::with(['company']);
        //Check if there is any search value
        if ($request->search != "") {
        }
        //Check in any type of sorting
        if ($request->sortBy != "") {
            //If the sorting is not related to Relations
            $employee = $employee->orderBy($request->sortBy, ($request->sortDesc == "true") ? "desc" : "asc");
        } else {
            //Default Sorting
            $employee = $employee->orderBy("id", "desc");
        }
        //Pagination
        if (isset($request->numRows) && $request->numRows > 0) {
            return $employee->paginate($request->numRows);
        } else {
            return $employee->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        // $employee = Employee::create($request->all());
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $employee = Employee::findOrfail($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        // Save the employee record to the database
        $employee->save();

        return response()->json("Record updated successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json("Record deleted successfully", 200);
    }
}
