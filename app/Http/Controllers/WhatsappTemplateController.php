<?php

namespace App\Http\Controllers;

use App\ServiceType;
use Illuminate\Http\Request;
use App\WhatsappTemplate;
use App\Client;
use Redirect;
use Session;

class WhatsappTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $templates = null;
        $current_user = \Auth::user();
        if($current_user->user_role == 'admin'){
            $templates = WhatsappTemplate::paginate(10);
        } elseif($current_user->user_role == 'client') {
            $client = Client::where('user_id',$current_user->id)->first();

            if($client != null) {
                $templates = WhatsappTemplate::where('client_id', $client->id)->paginate(10);
            }
        }

        return view('admin.whatsapp-templates.index', [
            'templates' => $templates
        ]);
    }

    public function create()
    {
        $service_types = null;
        $current_user = \Auth::user();
        if($current_user->user_role == 'admin'){
            $service_types = ServiceType::all();
        } elseif($current_user->user_role == 'client') {
            $client = Client::where('user_id',$current_user->id)->first();

            if($client != null) {
                $service_types = ServiceType::where('client_id','=',$client->id)->get();
            }
        }
        return view('admin.whatsapp-templates.create', compact('service_types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'template_text' => 'required',
            'service_type' => 'required'
        ]);

        $client = Client::where('user_id', \Auth::user()->id)->first();

        $template = new WhatsappTemplate();
        $template->name = $request->name;
        $template->template_text = $request->template_text;
        $template->client_id = $client->id;
        $template->service_type_id = $request->service_type;
        $template->variables = $request->variables;
        $template->status = 'pending';
        $template->save();

        Session::flash('success', 'New template was added successfully!');

        return Redirect::route('whatsapp-templates');
    }

    public function edit(WhatsappTemplate $template)
    {
        $service_types = null;
        $current_user = \Auth::user();
        if($current_user->user_role == 'admin'){
            $service_types = ServiceType::all();
        } elseif($current_user->user_role == 'client') {
            $client = Client::where('user_id',$current_user->id)->first();

            if($client != null) {
                $service_types = ServiceType::where('client_id','=',$client->id)->get();
            }
        }
        return view('admin.whatsapp-templates.edit', compact('template',
            'service_types'));
    }

    public function update(Request $request, WhatsappTemplate $template)
    {
        $request->validate([
            'name' => 'required|max:255',
            'template_text' => 'required',
            'service_type' => 'required'
        ]);

        $template->name = $request->name;
        $template->template_text = $request->template_text;
        $template->service_type_id = $request->service_type;
        $template->variables = $request->variables;
        $template->status = 'pending';
        $template->save();

        Session::flash('success', 'Template was updated successfully!');

        return Redirect::route('whatsapp-templates');
    }

    public function delete(WhatsappTemplate $template)
    {
        $template->delete();

        Session::flash('success', 'Template was deleted successfully!');

        return back();
    }
}
