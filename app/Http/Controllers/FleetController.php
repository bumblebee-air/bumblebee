<?php

namespace App\Http\Controllers;
use App\Fleet;
use App\FleetMember;
use App\SMS;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FleetImport;

class FleetController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAddFleet(){
        return view('company.fleet_add');
    }

    public function postAddFleet(Request $request){
        $current_user = Auth::user();
        try {
            $fleet_members = Excel::toArray(new FleetImport, request()->file('fleet_file'));
        } catch (\Exception $e){
            if(strpos($e->getMessage(),'beyond highest row')){
                \Session::flash('error','Sheet is empty');
                return redirect()->back();
            }
        }
        $the_fleet = new Fleet();
        $the_fleet->name = $request->get('name');
        $the_fleet->company_id = $current_user->id;
        $the_fleet->save();
        $errors = '';
        $added_users = 0;
        foreach($fleet_members[0] as $fleet_member){
            try {
                $user = User::create([
                    'name' => $fleet_member['first_name'] . ' ' . $fleet_member['last_name'],
                    'phone' => $fleet_member['mobile_phone_no'],
                    'password' => bcrypt('P@$$w0rd'),
                    'user_role' => 'customer'
                ]);
                $the_fleet_member = new FleetMember();
                $the_fleet_member->fleet_id = $the_fleet->id;
                $the_fleet_member->user_id = $user->id;
                $the_fleet_member->save();
                $added_users++;
            } catch (\Exception $e){
                if(strpos($e->getMessage(),'users_phone_unique')){
                    $errors .= 'The member '.$fleet_member['first_name'].' '.$fleet_member['last_name'].
                        ' was not added because the phone number is already in the system <br/>';
                }
            }
        }
        if($added_users===0){
            $the_fleet->delete();
            if($errors==''){
                $errors = 'No members were added and this fleet was not created';
            }
        }
        if($errors != ''){
            \Session::flash('error',$errors);
        } else {
            \Session::flash('success','Fleet was added successfully');
        }
        return redirect()->back();
    }

    public function viewFleets(){
        $current_user = Auth::user();
        $fleets = Fleet::where('company_id','=',$current_user->id)->get();
        return view('company.fleets_view',compact('fleets'));
    }

    public function viewFleet($id){
        $fleet = Fleet::find($id);
        if(!$fleet){
            return redirect()->back()->with('error','No fleet was found with this ID');
        }
        $fleet_members = FleetMember::with('the_user')->where('fleet_id','=',$id)->get();
        return view('company.fleet_view',compact('fleet_members'));
    }
}