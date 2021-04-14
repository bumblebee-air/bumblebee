<?php

namespace App\Http\Controllers;

use App\EnvData;
use Illuminate\Http\Request;

class EnvDataController extends Controller
{
    public function getEnvData() {
        $env_data = EnvData::paginate(50);
        return view('', ['env_data' => $env_data]);
    }

    public function getEditEnvData($id) {
        $env_data_row = EnvData::find($id);
        if (!$env_data_row) {
            abort(404);
        }
        return view('', ['env_data_row' => $env_data_row]);
    }

    public function postEditEnvData(Request $request, $id) {
        $env_data_row = EnvData::find($id);
        if (!$env_data_row) {
            abort(404);
        }
        $this->validate($request, [
            'client_id' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);
        $env_data_row->update([
            'client_id' => $request->client_id,
            'key' => $request->key,
            'value' => $request->value,
        ]);
        alert()->success('Env has been updated successfully');
        return redirect()->back();
    }

    public function postDeleteEnvData($id) {
        $env_data_row = EnvData::find($id);
        if (!$env_data_row) {
            abort(404);
        }
        $env_data_row->delete();
        alert()->success('Env has been deleted successfully');
        return redirect()->back();
    }
}
