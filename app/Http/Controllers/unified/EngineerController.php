<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use App\UnifiedEngineer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EngineerController extends Controller
{

    public function getEngineersList()
    {
        $engineers = UnifiedEngineer::all();
        return view('admin.unified.engineers.list', [
            'engineers' => $engineers
        ]);
    }

    public function deleteEngineer(Request $request)
    {
        $checkIfExists = UnifiedEngineer::find($request->engineerId);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$request->engineerId");
            return redirect()->back();
        }
        $checkIfExists->delete();
        alert()->success('Engineer deleted successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getAddEngineer(){
        
        return view('admin.unified.engineers.add_engineer');
    }
    
    public function postAddEngineer(Request $request) {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required',
            'job_type' => 'required|in:full_time,contract',
            'address_coordinates' => 'required',
        ]);
        UnifiedEngineer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'job_type' => $request->job_type,
        ]);
        alert()->success('Engineer added successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getSingleEngineer($client_name, $id) {
        $checkIfExists = UnifiedEngineer::find($id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$id");
            return redirect()->back();
        }
        
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $checkIfExists,
            'readOnly' => 1]);
    }
    
    public function getSingleEngineerEdit($client_name, $id) {
        $checkIfExists = UnifiedEngineer::find($id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$id");
            return redirect()->back();
        }
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $checkIfExists,
            'readOnly' => 0
        ]);
    }
    
    public function postEditEngineer(Request $request) {
        $checkIfExists = UnifiedEngineer::find($request->engineer_id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$request->engineer_id");
            return redirect()->back();
        }
        $checkIfExists->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'job_type' => $request->job_type,
        ]);
        alert()->success('Engineer updated successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
}

class Engineer
{

    public $id, $first_name, $last_name, $phone, $email, $address;

    public function __construct($id, $first_name, $last_name, $phone, $email, $address)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }
}
