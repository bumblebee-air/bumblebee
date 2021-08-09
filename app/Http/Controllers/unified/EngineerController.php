<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EngineerController extends Controller
{

    public function getEngineersList()
    {
        $engineer1 = new Engineer(1, "John", "Dow", "123456789", "john@mail.com", "Dublin");
        $engineer2 = new Engineer(2, "Adam", "Baxter", "123456789", "adam@mail.com", "Dublin");

        $engineers = array(
            $engineer1,
            $engineer2
        );

        return view('admin.unified.engineers.list', [
            'engineers' => $engineers
        ]);
    }

    public function deleteEngineer(Request $request)
    {
        //dd('delete engineer ' . $request->engineerId);
        alert()->success('Engineer deleted successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getAddEngineer(){
        
        return view('admin.unified.engineers.add_engineer');
    }
    
    public function postAddEngineer(Request $request) {
        //dd($request);
        alert()->success('Engineer added successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getSingleEngineer($client_name, $id) {
        $engineer = new Engineer($id, "John", "Dow", "123456789", "john@mail.com", "Dublin");
        
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $engineer,
            'readOnly' => 1]);
    }
    
    public function getSingleEngineerEdit($client_name, $id) {
        $engineer = new Engineer($id, "John", "Dow", "123456789", "john@mail.com", "Dublin");
        
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $engineer,
            'readOnly' => 0]);
    }
    
    public function postEditEngineer(Request $request) {
        //dd($request);
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