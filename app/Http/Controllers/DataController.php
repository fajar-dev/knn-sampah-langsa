<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index(Request $request){
        $search = $request->input('q');
        $data = Data::where('year', 'LIKE', '%' . $search . '%')->orderBy('year', 'asc')->paginate(25);
        $data->appends(['q' => $search]);
        $data = [
            'title' => 'Dataset',
            'subTitle' => null,
            'data' => $data
        ];

        return view('pages.data',  $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'year' => 'required|numeric|unique:data,year',
            'organic' => 'required|numeric',
            'unorganic' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->route('data')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        $data = New Data();
        $data->year = $request->year;
        $data->organic = $request->organic;
        $data->unorganic = $request->unorganic;
        $data->save();
        return redirect()->route('data')->with('success', 'Data has been added successfully');
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'year' => 'required|numeric|unique:data,year,' . $id,
            'organic' => 'required|numeric',
            'unorganic' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->route('data')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }
        $data = Data::find($id);
        $data->year = $request->year;
        $data->organic = $request->organic;
        $data->unorganic = $request->unorganic;
        $data->save();
        return redirect()->route('data')->with('success', 'Data has been updated successfully');
    }

    public function destroy($id){
        $data = Data::find($id);
        $data->delete();
        return redirect()->route('data')->with('success','Data has been deleted successfully');
    }

    public function import(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv'
        ]);
        if ($validator->fails()) {
            return redirect()->route('data')->with('error', 'Validation Error')->withInput()->withErrors($validator);
        }

        Excel::import(new DataImport, $request->file('file'));
        return redirect()->route('data')->with('success','Data has been imported successfully');
    }

    public function destroyAll(){
        Data::truncate(); 
        return redirect()->route('data')->with('success','Data has been deleted successfully');
    }
}
