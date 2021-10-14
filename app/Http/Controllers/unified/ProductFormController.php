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

//        $formFields = '[{"type":"checkbox-group","required":false,"label":"Checkbox 1","toggle":false,"inline":false,"name":"checkbox-1","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false}]},{"type":"checkbox-group","required":false,"label":"Checkbox 2","toggle":true,"inline":false,"name":"checkbox-group-1632997295288-0","values":[{"label":"Option 1","value":"option-1","selected":false}]},{"type":"date","required":false,"label":"Date","className":"form-control","name":"date"},{"type":"file","required":false,"label":"File Upload","className":"form-control","name":"file1","multiple":false},{"type":"file","required":false,"label":"File 2","className":"form-control","name":"file-2","multiple":true},{"type":"number","required":false,"label":"Number","className":"form-control","name":"number1","min":1,"step":1},{"type":"radio-group","required":false,"label":"Radio Group","inline":false,"name":"radio-group-1","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":false,"label":"Select","className":"form-control","name":"select-1","multiple":true,"values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":false,"label":"Select","className":"form-control","name":"select-1632997530971-0","multiple":false,"values":[{"label":"Select option","value":"","selected":true},{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"text","required":false,"label":"Text Field 1","className":"form-control","name":"text1","subtype":"text"},{"type":"text","subtype":"password","required":false,"label":"Password","className":"form-control","name":"password"},{"type":"text","subtype":"email","required":false,"label":"Email","className":"form-control","name":"email"},{"type":"text","subtype":"color","required":false,"label":"Color","className":"form-control","name":"color"},{"type":"text","subtype":"tel","required":false,"label":"Phone","className":"form-control","name":"phome"},{"type":"text","subtype":"datetime-local","required":false,"label":"Date &amp; time","className":"form-control","name":"date_time"},{"type":"text","subtype":"time","required":false,"label":"Time","className":"form-control","name":"time"},{"type":"text","subtype":"month","required":false,"label":"Month","className":"form-control","name":"month"},{"type":"text","subtype":"url","required":false,"label":"URL","className":"form-control","name":"url"},{"type":"text","subtype":"address","required":false,"label":"Address","className":"form-control","name":"address"},{"type":"textarea","required":false,"label":"Text Area","className":"form-control","name":"textarea1","rows":8}]';
//        $formFields = '[{"type":"checkbox-group","required":true,"label":"Checkbox 1","description":"checkbox 1 test","toggle":false,"inline":false,"name":"checkbox-group-1633298281568-0","values":[{"label":"Option 1","value":"1","selected":false},{"label":"Option 2","value":"2","selected":false}]},{"type":"checkbox-group","required":true,"label":"Checkbox Group","description":"toggle checkbox","toggle":true,"inline":false,"name":"checkbox-group-1633298322905-0","values":[{"label":"Option 1","value":"option-1","selected":false}]},{"type":"date","required":false,"label":"Date Field","description":"date ","placeholder":"enter date","className":"form-control","name":"date-1633298356653-0"},{"type":"file","required":false,"label":"File Upload","description":"file upload","placeholder":"Upload file","className":"form-control","name":"file-1633298384910-0","multiple":false},{"type":"file","required":false,"label":"Files Upload","description":"test files upload","placeholder":"Upload files","className":"form-control","name":"file-1633298415878-0","multiple":true},{"type":"number","required":false,"label":"Number","description":"test number","placeholder":"Enter number","className":"form-control","name":"number-1633298439727-0","min":1,"max":100,"step":2},{"type":"radio-group","required":true,"label":"Radio Group","description":"test radio group","inline":false,"name":"radio-group-1633298501255-0","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"radio-group","required":true,"label":"Radio Group 5","description":"test 5 radio group","inline":false,"name":"radio-group-55555-0","values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":true,"label":"Select","description":"select option","placeholder":"Select one option","className":"form-control","name":"select-1633298517317-0","multiple":false,"values":[{"label":"Option 1","value":"option-1","selected":false},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]},{"type":"select","required":true,"label":"Select multi","description":"select multi test","placeholder":"Select options","className":"form-control","name":"select-1633298544330-0","multiple":true,"values":[{"label":"Option 1","value":"1","selected":false},{"label":"Option 2","value":"2","selected":false},{"label":"Option 3","value":"3","selected":false},{"label":"Option 4","value":"4","selected":false}]},{"type":"textarea","required":false,"label":"Text Area","description":"textarea desc. ","placeholder":"Enter desc.","className":"form-control","name":"textarea-1633298594672-0","maxlength":10,"rows":5},{"type":"text","required":false,"label":"Text Field","description":"Name","placeholder":"Enter text field","className":"form-control","name":"text-1633298626669-0","subtype":"text","maxlength":5},{"type":"text","subtype":"password","required":false,"label":"Password","description":"password ","placeholder":"Enter password","className":"form-control","name":"text-1633298677043-0"},{"type":"text","subtype":"email","required":false,"label":"Email","description":"text email","placeholder":"Enter email","className":"form-control","name":"text-1633298703355-0"},{"type":"text","subtype":"tel","required":false,"label":"Phone number","description":"phone ","className":"form-control","name":"text-1633298720457-0"},{"type":"text","subtype":"datetime-local","required":false,"label":"Date time","description":"enter date and time","placeholder":"Enter date ","className":"form-control","name":"text-1633298735120-0"},{"type":"text","subtype":"time","required":false,"label":"Time","description":"time ","placeholder":"Enter time","className":"form-control","name":"text-1633298770507-0"},{"type":"text","subtype":"month","required":false,"label":"Month","description":"month and year","placeholder":"Enter month","className":"form-control","name":"text-1633298786475-0"},{"type":"text","subtype":"url","required":false,"label":"URL","description":"account url","placeholder":"Enter url","className":"form-control","name":"text-1633298808363-0"},{"type":"text","subtype":"address","required":false,"label":"Location","description":"Addess in google ","placeholder":"Enter location","className":"form-control","name":"text-1633298827494-0"}]';
//        $fields = array();
//
//        $field1 = new FormFieldsData("Checkbox 1", "checkbox-group", null, false, "checkbox1", null, null, array(2,11));
//        $field1->toggle=false;
//        $values1 = array(
//            array("label"=> "Option 1","value"=> 1,"selected"=>false),
//            array("label"=> "Option 2","value"=> 2,"selected"=>false),
//            array("label"=> "Option 3","value"=> 3,"selected"=>false),
//        );
//        $field1->values = $values1;
//        array_push($fields,$field1);
//
//        $field2 = new FormFieldsData("Checkbox 2", "checkbox-group", null, false, "checkboxtoggle", null, null, array(2,4));
//        $field2->toggle=true;
//        $values2 = array(
//            array("label"=> "Option toggle 1","value"=> 1,"selected"=>false),
//            array("label"=> "Option toggle 2","value"=> 2,"selected"=>false),
//            array("label"=> "Option toggle 3","value"=> 3,"selected"=>false),
//            array("label"=> "Option toggle 4","value"=> 4,"selected"=>false),
//        );
//        $field2->values = $values2;
//        array_push($fields,$field2);
//
//        $field3 = new FormFieldsData("Date", "date", null, true, "date", null, "Enter date", "10/14/2021");
//        array_push($fields,$field3);
//
//
//        $field4 = new FormFieldsData("File upload", "file", null, false, "file1", null, "Upload file",
//            array('images/unified/Add Service Form.png'));
//        $field4->multiple=false;
//        array_push($fields,$field4);
//
//        $field5 = new FormFieldsData("Files upload", "file", null, false, "file2", null, "Upload filess",
//            array('images/unified/Add Service Form.png','images/unified/Calendar.png'));
//        $field5->multiple=true;
//        array_push($fields,$field5);
//
//        $field6 = new FormFieldsData("Number", "number", null, true, "number_of_user", null, "Enter number", 10);
//        $field6->min=1; $field6->max=100; $field6->step=1;
//        array_push($fields,$field6);
//
//        $field7 = new FormFieldsData("Radio group", "radio-group", null, true, "radio-group-1111", null, null, 'option-2');
//        $values = array(
//            array("label"=> "Option 1","value"=> "option-1","selected"=>false),
//            array("label"=> "Option 2","value"=> "option-2","selected"=>false),
//            array("label"=> "Option 3","value"=> "option-3","selected"=>false),
//        );
//        $field7->values = $values;
//        array_push($fields,$field7);
//
//        $field8 = new FormFieldsData("Select field", "select", null, true, "select_111", null, "Select one option", 'options-3');
//        $field8->multiple=false;
//        $values8 = array(
//            array("label"=> "Options 1","value"=> "options-1","selected"=>false),
//            array("label"=> "Options 2","value"=> "options-2","selected"=>false),
//            array("label"=> "Options 3","value"=> "options-3","selected"=>false),
//            array("label"=> "Options 4","value"=> "options-4","selected"=>false),
//        );
//        $field8->values = $values8;
//        array_push($fields,$field8);
//
//        $field9 = new FormFieldsData("Select multi", "select", null, true, "select_222", null, "Select options", array('options-2','options-4'));
//        $field9->multiple=true;
//        $values9 = array(
//            array("label"=> "Options 1","value"=> "options-1","selected"=>false),
//            array("label"=> "Options 2","value"=> "options-2","selected"=>false),
//            array("label"=> "Options 3","value"=> "options-3","selected"=>false),
//            array("label"=> "Options 4","value"=> "options-4","selected"=>false),
//        );
//        $field9->values = $values9;
//        array_push($fields,$field9);
//
//        $field10 = new FormFieldsData("Textarea", "textarea", null, true, "textarea1", null, "Enter details ", "test test");
//        $field10->maxlength=20; $field10->rows=5;
//        array_push($fields,$field10);
//
//        $field11 = new FormFieldsData("Text field", "text", "text", true, "text-44444", null, "Enter text", "test");
//        $field11->maxlength=6;
//        array_push($fields,$field11);
//
//        $field12 = new FormFieldsData("Password", "text", "password", true, "password", null, "Enter password", "123456");
//        array_push($fields,$field12);
//
//        $field13 = new FormFieldsData("Email", "text", "email", true, "email", "Email text", "Enter email", "example@mail.com");
//        array_push($fields,$field13);
//
//        $field14 = new FormFieldsData("Phone", "text", "tel", false, "phone_number", "your mobile number", "Enter phone", "123456789");
//        array_push($fields,$field14);
//
//
//        $field15 = new FormFieldsData("Date time", "text", "datetime-local", true, "datetime", null, null, "10/14/2021 11:25 AM");
//        array_push($fields,$field15);
//
//        $field16 = new FormFieldsData("Time", "text", "time", true, "text-123456", "time", "Enter time", "13:00");
//        array_push($fields, $field16);
//
//        $field17 = new FormFieldsData("Month", "text", "month", true, "text-1633298786475-0", "month and year", "Enter month","Oct 2021");
//        array_push($fields, $field17);
//
//        $field18 = new FormFieldsData("URL", "text", "urk", false, "text-url", null, "Enter url", "http://www.google.com");
//        array_push($fields,$field18);
//
//        $field19 = new FormFieldsData("Location", "text", "address", false, "location", null, "Enter address", "Phoenix Park, Dublin 8, Ireland");
//        $field19->coordinates = '{"lat": 53.35588, "lon": -6.32981}';
//        array_push($fields,$field19);
//
//
//        $field20 = new FormFieldsData("Color", "text", "color", false, "color", null, "Enter color", "#ff00ff");
//        array_push($fields,$field20);
//
//        $formFields = json_encode($fields);

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

//class FormFieldsData
//{
//
//    // $min,$max,$step ===> for input type :number
//    // $maxlength ===> for input type: text and textarea
//    // $row ===> for textarea
//    // $toggle ===> for checkbox input
//    // $multiple ===> multi select or multi upload files
//    // $values ===> for checkbox, radio buttons and select ex.: "values":[{"label":"Option 1","value":"1","selected":false},{"label":"Option 2","value":"2","selected":false}]
//    public $label, $type, $subtype, $required, $toggle, $name, $values, $multiple, $description, $placeholder, $min, $max, $step, $maxlength, $rows,$selected_value;
//
//    public function __construct($label, $type, $subtype, $required, $name, $description, $placeholder,$selected_value)
//    {
//        $this->label = $label;
//        $this->type = $type;
//        $this->subtype = $subtype;
//        $this->required = $required;
//        $this->name = $name;
//        $this->description = $description;
//        $this->placeholder = $placeholder;
//        $this->selected_value = $selected_value;
//    }
//}

