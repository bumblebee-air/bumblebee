<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceType;
use App\SupportType;
use Validator;
use Input;
use Session;

class SupportController extends Controller
{
    public function index()
    {
        $supportTypes = SupportType::with('serviceType')->paginate(10);

        return view('admin.support-types.index', [
            'supportTypes' => $supportTypes
        ]);
    }

    public function addSupportType()
    {
        $serviceTypes = ServiceType::get();
        return view('admin.support-types.create', [
            'serviceTypes' => $serviceTypes
        ]);
    }

    public function store(Request $request)
    {
        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $supportType = new SupportType();
        $supportType->name = $request->name;
        $supportType->service_type_id = $request->service_type;
        $supportType->save();

        Session::flash('success', 'New support type was added successfully!');

        return redirect()->to('support-types');
    }

    public function edit(Request $request, SupportType $supportType)
    {
        $serviceTypes = ServiceType::get();

        return view('admin.support-types.edit', [
            'supportType' => $supportType,
            'serviceTypes' => $serviceTypes
        ]);
    }

    public function update(Request $request, SupportType $supportType)
    {
        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $supportType->name = $request->name;
        $supportType->service_type_id = $request->service_type;
        $supportType->save();

        Session::flash('success', 'Support type was updated successfully!');

        return redirect()->to('support-types');
    }

    public function destroy(SupportType $supportType)
    {
        $supportType->delete();

        Session::flash('success', 'Support type was deleted successfully!');

        return redirect()->back();
    }

    private function validateForm()
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}
