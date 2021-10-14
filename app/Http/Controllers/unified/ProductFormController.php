<?php
namespace App\Http\Controllers\unified;

use App\ServiceType;
use App\UnifiedCustomerProductSelectedValues;
use App\UnifiedService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnifiedCustomer;
use phpDocumentor\Reflection\PseudoTypes\False_;

class ProductFormController extends Controller
{

    public function getProductTypesList()
    {
        $product_types = UnifiedService::all();

        return view('admin.unified.product_form.product_type_list', [
            'product_types' => $product_types
        ]);
    }

    public function deleteProductType(Request $request)
    {
        alert()->success('Product type deleted successfully');
        return redirect()->route('unified_getProductTypesList', 'unified');
    }

    public function getAddProductType()
    {
        return view('admin.unified.product_form.add_product_type');
    }

    public function postAddProductType(Request $request)
    {
        // data to use: product_type_name , border_color , background_color , form_builder_data
        $product = new UnifiedService();
        $product->name = $request->product_type_name;
        $product->borderColor = $request->borderColor ?: '#000000';
        $product->backgroundColor = $request->backgroundColor ?: '#000000';
        $product->formData = $request->form_builder_data;
        $product->service_code = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $request->product_type_name));
        $product->save();

        alert()->success('Product type saved successfully');
        return redirect()->route('unified_getProductTypesList', 'unified');
    }

    public function getSingleProductType($client_name, $id)
    {
        $productType = UnifiedService::find($id);

        return view('admin.unified.product_form.single_product_type', [
            'productType' => $productType,
            'readOnly' => 1
        ]);
    }

    public function getSingleProductTypeEdit($client_name, $id)
    {
        $productType = UnifiedService::find($id);
        return view('admin.unified.product_form.single_product_type', [
            'productType' => $productType,
            'readOnly' => 0
        ]);
    }

    public function postEditProductType(Request $request)
    {
        $product = UnifiedService::find($request->product_type_id);
        if (! $product) {
            alert()->error('The product type was not exist.');
            return redirect()->back();
        }
        $product->name = $request->product_type_name;
        $product->borderColor = $request->borderColor;
        $product->backgroundColor = $request->backgroundColor;
        $product->formData = $request->form_builder_data;
        $product->save();

        alert()->success('Product type has updated successfully');
        return redirect()->route('unified_getProductTypesList', 'unified');
    }

    public function getProductForm()
    {
        // dd("get product form");
        $customers = UnifiedCustomer::select([
            'id',
            'name'
        ])->get();

        // dd($customers);
        return view('admin.unified.product_form.add_product_form', [
            'customers' => $customers
        ]);
    }

    public function postSaveProductForm(Request $request)
    {
//        dd($request->all());
        $customer_id = $request->customer_id;
        $service_id = $request->productTypeSelect;
        $array = [];
        foreach ($request->all() as $key => $request_inputs) {
            if (!in_array($key, ['_token', 'customer_id', 'productTypeSelect'])) {
                if (substr($key, 0, 4) == 'file') {
                    //The files are overwritten here. How can the user remove a file?
                    $paths = [];
                    foreach ($request[$key] as $file_key => $file) {
                        $paths[] = $request[$key][$file_key]->store('uploads');
                    }
                    $array[$key] = $paths;

                } else {
                    $array[$key] = $request_inputs;
                }
            }
        }
        $customer_product_selected_values =  UnifiedCustomerProductSelectedValues::where('customer_id', $customer_id)
            ->where('service_id', $service_id)->first();
        if ($customer_product_selected_values) {
            $customer_product_selected_values->update([
                'selected_values' => $array
            ]);
        } else {
            UnifiedCustomerProductSelectedValues::create([
                'service_id' => $service_id,
                'customer_id' => $customer_id,
                'selected_values' => $array
            ]);
        }
        alert()->success('Product has saved successfully.');
        return redirect()->back();
    }

    public function getProductTypesOfCustomer(Request $request)
    {
        $customerData = UnifiedCustomer::find($request->customerId);
        $productTypesIDs = array_column($customerData->services->toArray(), 'service_id');
        $productTypes = UnifiedService::whereIn('id', $productTypesIDs)->get();

        return response()->json(array(
            "msg" => "get product types of customer",
            "productTypes" => $productTypes
        ));
    }

    public function getFormFieldsOfProductType(Request $request)
    {
        $productTypeID = $request->productTypeId;
        $customerId = $request->customerId;

        $service = UnifiedService::find($productTypeID);
        $selected_values = UnifiedCustomerProductSelectedValues::where('customer_id', $customerId)
            ->where('service_id', $productTypeID)->first();
        $formData_decoded = json_decode($service->formData);
        foreach ($formData_decoded as $key => $formData_input) {
            if (array_key_exists($formData_input->name, $selected_values->selected_values)) {
                $formData_decoded[$key]->selected_value = $selected_values->selected_values[$formData_input->name];
            }
        }
        return response()->json(array(
            "msg" => "get form fields of product type",
            "formFields" => json_encode($formData_decoded),
            "productTypeID" => $productTypeID,
            "customerID" => $customerId
        ));
    }
}

