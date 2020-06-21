<?php

namespace App\Http\Controllers;

use App\Imports\SupplierImport;
use App\Schedule;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['getSupplierScheduleForm','postSupplierScheduleForm']);
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

    public function getSupplierScheduleForm($code){
        $supplier = Supplier::where('security_code','=',$code)->first();
        $the_supplier_schedule = null;
        if($supplier){
            $supplier_schedule = Schedule::where('entity','=','supplier')
                ->where('entity_id','=',$supplier->id)->first();
            if($supplier_schedule!=null) {
                $the_supplier_schedule = json_decode($supplier_schedule->week_days);
            }
        }
        return view('supplier_schedule_form',compact('supplier','the_supplier_schedule'));
    }

    public function postSupplierScheduleForm(Request $request){
        $supplier_id = $request->get('supplier_id');
        $schedule_array = [];
        $sunday_from = $request->get('sun_from'); $sunday_to = $request->get('sun_to');
        $monday_from = $request->get('mon_from'); $monday_to = $request->get('mon_to');
        $tuesday_from = $request->get('tue_from'); $tuesday_to = $request->get('tue_to');
        $wednesday_from = $request->get('wed_from'); $wednesday_to = $request->get('wed_to');
        $thursday_from = $request->get('thu_from'); $thursday_to = $request->get('thu_to');
        $friday_from = $request->get('fri_from'); $friday_to = $request->get('fri_to');
        $saturday_from = $request->get('sat_from'); $saturday_to = $request->get('sat_to');
        $schedule_array['sun'] = [$sunday_from,$sunday_to];
        $schedule_array['mon'] = [$monday_from,$monday_to];
        $schedule_array['tue'] = [$tuesday_from,$tuesday_to];
        $schedule_array['wed'] = [$wednesday_from,$wednesday_to];
        $schedule_array['thu'] = [$thursday_from,$thursday_to];
        $schedule_array['fri'] = [$friday_from,$friday_to];
        $schedule_array['sat'] = [$saturday_from,$saturday_to];
        $supplier_schedule = Schedule::where('entity','=','supplier')
            ->where('entity_id','=',$supplier_id)->first();
        if(!$supplier_schedule){
            $supplier_schedule = new Schedule();
            $supplier_schedule->entity = 'supplier';
            $supplier_schedule->entity_id = $supplier_id;
        }
        $supplier_schedule->week_days = json_encode($schedule_array);
        $supplier_schedule->save();
        \Session::flash('success','The schedule was updated successfully');
        return redirect()->back();
    }
}
