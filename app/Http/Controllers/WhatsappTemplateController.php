<?php

namespace App\Http\Controllers;

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
        $client = Client::where('user_id', \Auth::user()->id)->first();
        $templates = WhatsappTemplate::where('client_id', $client->id)->paginate(10);

        return view('admin.whatsapp-templates.index', [
            'templates' => $templates
        ]);
    }

    public function create()
    {
        return view('admin.whatsapp-templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'template_text' => 'required',
        ]);

        $client = Client::where('user_id', \Auth::user()->id)->first();

        $template = new WhatsappTemplate();
        $template->name = $request->name;
        $template->template_text = $request->template_text;
        $template->client_id = $client->id;
        $template->status = 'pending';
        $template->save();

        Session::flash('success', 'New template was added successfully!');

        return Redirect::route('whatsapp-templates');
    }

    public function edit(WhatsappTemplate $template)
    {
        return view('admin.whatsapp-templates.edit', [
            'template' => $template
        ]);
    }

    public function update(Request $request, WhatsappTemplate $template)
    {
        $request->validate([
            'name' => 'required|max:255',
            'template_text' => 'required',
        ]);

        $template->name = $request->name;
        $template->template_text = $request->template_text;
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
