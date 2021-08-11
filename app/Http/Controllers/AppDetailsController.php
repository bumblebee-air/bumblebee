<?php

namespace App\Http\Controllers;

use App\AppDetails;
use App\Client;
use Illuminate\Http\Request;

class AppDetailsController extends Controller
{
    public function view(Request $request) {
        $this->validate($request, [
            'client' => 'required|exists:clients,name',
            'os' => 'required|in:android,ios'
        ]);
        $client = Client::where('name', $request->client)->first();
        $app_details = AppDetails::where('client_id',$client->id)->where('os', $request->os)->first();

        return response()->json([
            'data' => $app_details,
        ]);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'client' => 'required|exists:clients,name',
            'os' => 'required|in:android,ios',
            'version' => 'required'
        ]);
        $client = Client::where('name', $request->client)->first();
        $app_details = AppDetails::where('client_id', $client->id)->where('os', $request->os)->first();
        if ($app_details) {
            $app_details->update([
                'version' => $request->version,
                'os' => $request->os,
            ]);
        } else {
            $app_details = AppDetails::create([
                'client_id' => $client->id,
                'version' => $request->version,
                'os' => $request->os,
            ]);
        }
        return response()->json([
            'data' => $app_details,
        ]);
    }
}
