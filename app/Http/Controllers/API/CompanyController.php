<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Notifications\NewCompanyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Declare a global variable with relation orders!
        $company =  Company::whereNotNull('name');
        //Check if there is any search value
        if ($request->search != "") {
        }
        //Check in any type of sorting
        if ($request->sortBy != "") {
            //If the sorting is not related to Relations
            $company = $company->orderBy($request->sortBy, ($request->sortDesc == "true") ? "desc" : "asc");
        } else {
            //Default Sorting
            $company = $company->orderBy("id", "desc");
        }
        //Pagination
        if (isset($request->numRows) && $request->numRows > 0) {
            return $company->paginate($request->numRows);
        } else {
            return $company->get();
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|nullable',
            'logo' => ['required', Rule::dimensions()->minWidth(1000)->minHeight(1000)],
            'website' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create a new Company record
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        // Handle the logo file upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('public/logos');
            $company->logo = str_replace('public/', '', $logoPath);
        }
        // Save the Company record to the database
        $company->save();
        // Send the email notification without associating it with a specific user
        Notification::send(Notification::route('HR', 'hello@xepos.co.uk'), new NewCompanyNotification($company));

        // Return the newly created company as a JSON response
        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|nullable',
            'logo' =>  ['required', Rule::dimensions()->minWidth(1000)->minHeight(1000)],
            'website' => 'required',
        ]);
        $company = Company::findOrfail($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        // Handle the logo file upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('public/logos');
            $company->logo = str_replace('public/', '', $logoPath);
        }
        // Save the Company record to the database
        $company->save();

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
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json("Record deleted successfully", 200);
    }
    public function getCompanies()
    {
        $companies = Company::all();

        return $companies;
    }
}
