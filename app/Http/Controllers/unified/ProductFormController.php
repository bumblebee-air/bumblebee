<?php
namespace App\Http\Controllers\unified;

use App\UnifiedService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnifiedCustomer;

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
        $product->borderColor = $request->borderColor?: '#000000';
        $product->backgroundColor = $request->backgroundColor?: '#000000' ;
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
        if (!$product) {
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
            'customers' => $customers,
        ]);
    }

    public function postSaveProductForm(Request $request)
    {
        dd($request);
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
    
    public function getFormFieldsOfProductType(Request $request){
        
        $productTypeID =  $request->productTypeId;
        
        $formFields = '[{"type":"checkbox-group","required":false,"label":"Checkbox 1","toggle":false,"inline":false,"name":"checkbox-1","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false}]},{"type":"checkbox-group","required":false,"label":"Checkbox 2","toggle":true,"inline":false,"name":"checkbox-group-1632997295288-0","values":[{"label":"Option 1","value":"option-1","selected":false}]},{"type":"date","required":false,"label":"Date","className":"form-control","name":"date"},{"type":"file","required":false,"label":"File Upload","className":"form-control","name":"file1","multiple":false},{"type":"file","required":false,"label":"File 2","className":"form-control","name":"file-2","multiple":true},{"type":"number","required":false,"label":"Number","className":"form-control","name":"number1","min":1,"step":1},{"type":"radio-group","required":false,"label":"Radio Group","inline":false,"name":"radio-group-1","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":false,"label":"Select","className":"form-control","name":"select-1","multiple":true,"values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":false,"label":"Select","className":"form-control","name":"select-1632997530971-0","multiple":false,"values":[{"label":"Select option","value":"","selected":true},{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"text","required":false,"label":"Text Field 1","className":"form-control","name":"text1","subtype":"text"},{"type":"text","subtype":"password","required":false,"label":"Password","className":"form-control","name":"password"},{"type":"text","subtype":"email","required":false,"label":"Email","className":"form-control","name":"email"},{"type":"text","subtype":"color","required":false,"label":"Color","className":"form-control","name":"color"},{"type":"text","subtype":"tel","required":false,"label":"Phone","className":"form-control","name":"phome"},{"type":"text","subtype":"datetime-local","required":false,"label":"Date &amp; time","className":"form-control","name":"date_time"},{"type":"text","subtype":"time","required":false,"label":"Time","className":"form-control","name":"time"},{"type":"text","subtype":"month","required":false,"label":"Month","className":"form-control","name":"month"},{"type":"text","subtype":"url","required":false,"label":"URL","className":"form-control","name":"url"},{"type":"text","subtype":"address","required":false,"label":"Address","className":"form-control","name":"address"},{"type":"textarea","required":false,"label":"Text Area","className":"form-control","name":"textarea1","rows":8}]';
        
        return response()->json(array(
            "msg" => "get form fields of product type",
            "formFields" => $formFields
        ));
    }
}
