<?php

namespace App\Http\Controllers;

use App\Imports\SupplierImport;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getSuppliersIndex(){
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function getSuppliersImport(){
        return view('admin.suppliers.import');
    }

    public function postSuppliersImport(Request $request){
        //dd($request->all());
        $suppliers_file = $request->file('suppliers_file');
        if(!$suppliers_file){
            \Session::flash('error', 'No file was uploaded');
            return redirect()->back();
        }
        $suppliers = \Excel::import(new SupplierImport, $suppliers_file);
        \Session::flash('success','Suppliers imported successfully');
        return redirect()->to('suppliers');
    }

    public function deleteAllSuppliers(Request $request){
        $do_delete = $request->get('do_delete');
        if(!$do_delete){
            return redirect()->back();
        }
        Supplier::truncate();
        \Session::flash('success','All Suppliers have been deleted successfully');
        return redirect()->back();
    }
}
