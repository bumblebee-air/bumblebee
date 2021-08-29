<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenInsuranceController extends Controller
{

    public function getInsuranceEntity()
    {
        $entityTypes = $this->getEntityTypes();
        $classifications = $this->getClassifications();
        $productCatalogs = $this->getProductCatalogs();

        return view('open_insurance.insurance_entity', [
            'entityTypes' => $entityTypes,
            'classifications' => $classifications,
            'productCatalogs' => $productCatalogs
        ]);
    }

    public function postInsuranceEntity(Request $request)
    {
        // dd($request);
        alert()->success('Insurance entity saved successfully');
        return redirect()->back();
    }

    public function getPersonal()
    {
        $salutations = $this->getSalutations();
        $sexList = $this->getSexList();
        $idTypes = $this->getIdTypes();
        $occupations = array();
        $products = $this->getProducts();

        return view('open_insurance.personal', [
            'salutations' => $salutations,
            'sexList' => $sexList,
            'idTypes' => $idTypes,
            'occupations' => $occupations,
            'products' => $products
        ]);
    }

    public function postPersonal(Request $request)
    {
        // dd($request);
        alert()->success('Personal saved successfully');
        return redirect()->back();
    }

    public function getCommercial()
    {
        $products = $this->getProducts();

        return view('open_insurance.commercial', [
            'products' => $products
        ]);
    }

    public function postCommercial(Request $request)
    {
        // dd($request);
        alert()->success('Commercial saved successfully');
        return redirect()->back();
    }

    public function getDriver()
    {
        $sexList = $this->getSexList();
        $workStatusList = $this->getWorkStatusList();
        $vehicles = $this->getVehicles();

        return view('open_insurance.driver', [
            'sexList' => $sexList,
            'workStatusList' => $workStatusList,
            'vehicles' => $vehicles
        ]);
    }

    public function postDriver(Request $request)
    {
        // dd($request);
        alert()->success('Driver saved successfully');
        return redirect()->back();
    }

    public function getVehicle()
    {
        $bodyTypes = $this->getBodyTypes();
        $fuelTypes = $this->getFuelTypes();
        $aiClassifications = $this->getAiClassifications();
        $vehicleUses = $this->getVehicleUses();

        return view('open_insurance.vehicle', [
            'bodyTypes' => $bodyTypes,
            'fuelTypes' => $fuelTypes,
            'aiClassifications' => $aiClassifications,
            'vehicleUses' => $vehicleUses
        ]);
    }

    public function postVehicle(Request $request)
    {
        // dd($request);
        alert()->success('Vehicle saved successfully');
        return redirect()->back();
    }

    public function getProduct()
    {
        $productCatalogs = $this->getProductCatalogs();
        $productModels = $this->getProductModels();
        $contractTypes = $this->getContractTypes();
        $currencies = $this->getCurrencies();
        $paymentMethods = $this->getPaymentMethods();
        $coverages = $this->getCoverages();

        return view('open_insurance.product', [
            'productCatalogs' => $productCatalogs,
            'productModels' => $productModels,
            'contractTypes' => $contractTypes,
            'currencies' => $currencies,
            'paymentMethods' => $paymentMethods,
            'coverages' => $coverages
        ]);
    }

    public function postProduct(Request $request)
    {
        // dd($request);
        alert()->success('Product saved successfully');
        return redirect()->back();
    }

    public function getClaim()
    {
        $claimTypes = $this->getClaimTypes();
        $perils = $this->getPerils();
        $claimStatusList = $this->getClaimStatusList();
        $paymentMethods = $this->getPaymentMethods();

        return view('open_insurance.claim', [
            'claimTypes' => $claimTypes,
            'perils' => $perils,
            'claimStatusList' => $claimStatusList,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function postClaim(Request $request)
    {
        // dd($request);
        alert()->success('Claim saved successfully');
        return redirect()->back();
    }
    
    public function getCoverage(){
        return view('open_insurance.coverage');
    }
    public function postCoverage(Request $request)
    {
        // dd($request);
        alert()->success('Coverage saved successfully');
        return redirect()->back();
    }
    
    public function getBeneficiary(){
        return view('open_insurance.beneficiary');
    }
    public function postBeneficiary(Request $request)
    {
        // dd($request);
        alert()->success('Beneficiary saved successfully');
        return redirect()->back();
    }
    public function getReceipt(){
        return view('open_insurance.receipt');
    }
    public function postReceipt(Request $request)
    {
        // dd($request);
        alert()->success('Receipt saved successfully');
        return redirect()->back();
    }
    public function getPremiumBordereau(){
        return view('open_insurance.premium_bordereau');
    }
    public function postPremiumBordereau(Request $request)
    {
        // dd($request);
        alert()->success('Premium bordereau saved successfully');
        return redirect()->back();
    }
    public function getClaimsBordereau(){
        return view('open_insurance.claims_bordereau');
    }
    public function postClaimsBordereau(Request $request)
    {
        // dd($request);
        alert()->success('Claims bordereau saved successfully');
        return redirect()->back();
    }

    
    private function getEntityTypes()
    {
        $entityType1 = new ItemData(1, "reinsurance company");
        $entityType2 = new ItemData(2, "insurance company");
        $entityType3 = new ItemData(3, "takaful reinsurance comapny");
        $entityType4 = new ItemData(4, "takaful insurance company");
        $entityType5 = new ItemData(5, "mutual insurance company");
        $entityType6 = new ItemData(6, "peer-to-peer insurance company");
        $entityType7 = new ItemData(7, "Lloyds syndicate");
        $entityType8 = new ItemData(8, "reinsurance pool");
        $entityType9 = new ItemData(9, "captive insurance company");
        $entityType10 = new ItemData(10, "decentralized autonomous organization");
        $entityType11 = new ItemData(11, "insurance broker");
        $entityType12 = new ItemData(12, "insurance agent");
        $entityType13 = new ItemData(13, "managing general agent");
        $entityType14 = new ItemData(14, "insurance introducer");
        $entityType15 = new ItemData(15, "price aggregator");
        $entityType16 = new ItemData(16, "insurance prediction market");
        $entityType17 = new ItemData(17, "other");

        $entityTypes = array(
            $entityType1,
            $entityType2,
            $entityType3,
            $entityType4,
            $entityType5,
            $entityType6,
            $entityType7,
            $entityType8,
            $entityType9,
            $entityType10,
            $entityType11,
            $entityType12,
            $entityType13,
            $entityType14,
            $entityType15,
            $entityType16,
            $entityType17
        );

        return $entityTypes;
    }

    private function getClassifications()
    {
        $classification1 = new ItemData(1, "property and casualty insurer");
        $classification2 = new ItemData(2, "life insurer");
        $classification3 = new ItemData(3, "composite insurer");
        $classification4 = new ItemData(4, "other");

        $classifications = array(
            $classification1,
            $classification2,
            $classification3,
            $classification4
        );
        return $classifications;
    }

    private function getProductCatalogs()
    {
        $productCatalog1 = new ItemData(1, "property fire insurance");
        $productCatalog2 = new ItemData(2, "burglary insurance");
        $productCatalog3 = new ItemData(3, "renters insurance");
        $productCatalog4 = new ItemData(4, "home and content insurance");
        $productCatalog5 = new ItemData(5, "property flood insurance");
        $productCatalog6 = new ItemData(6, "debris removal insurance");
        $productCatalog7 = new ItemData(7, "motor comprehensive insurance");
        $productCatalog8 = new ItemData(8, "motor third party liability insurance");
        $productCatalog9 = new ItemData(9, "land transit insurance");
        $productCatalog10 = new ItemData(10, "marine cargo insurance");
        $productCatalog11 = new ItemData(11, "marine hull and machinery insurance");
        $productCatalog12 = new ItemData(12, "marine protection and indemnity");
        $productCatalog13 = new ItemData(13, "carriers liability insurance");
        $productCatalog14 = new ItemData(14, "medical insurance");
        $productCatalog15 = new ItemData(15, "construction all risks insurance");
        $productCatalog16 = new ItemData(16, "engineering contractor plant and machinery insurance");
        $productCatalog17 = new ItemData(17, "electronic equipment insurance");
        $productCatalog18 = new ItemData(18, "equipment breakdown insurance");
        $productCatalog19 = new ItemData(19, "decenial liability insurance");
        $productCatalog20 = new ItemData(20, "deterioration of stock insurance");
        $productCatalog21 = new ItemData(21, "boiler and machinery insurance");
        $productCatalog22 = new ItemData(22, "glass insurance");
        $productCatalog23 = new ItemData(23, "money cash in transit insurance");
        $productCatalog24 = new ItemData(24, "money cash in safe insurance");
        $productCatalog25 = new ItemData(25, "fidelity guarantee insurance");
        $productCatalog26 = new ItemData(26, "workers compensation insurance");
        $productCatalog27 = new ItemData(27, "pet insurance");
        $productCatalog28 = new ItemData(28, "bloodstock insurance");
        $productCatalog29 = new ItemData(29, "livestock insurance");
        $productCatalog30 = new ItemData(30, "personal accident insurance");
        $productCatalog31 = new ItemData(31, "term life insurance");
        $productCatalog32 = new ItemData(32, "whole of life insurance");
        $productCatalog33 = new ItemData(33, "medical malpractice insurance");
        $productCatalog34 = new ItemData(34, "professional indemnity insurance");
        $productCatalog35 = new ItemData(35, "trade credit insurance");
        $productCatalog36 = new ItemData(36, "purchase protection insurance");
        $productCatalog37 = new ItemData(37, "travel insurance");
        $productCatalog38 = new ItemData(38, "legal expense insurance");
        $productCatalog39 = new ItemData(39, "cyber liability insurance");
        $productCatalog40 = new ItemData(40, "business interruption insurance");
        $productCatalog41 = new ItemData(41, "directors and officers insurance");
        $productCatalog42 = new ItemData(42, "key person insurance");
        $productCatalog43 = new ItemData(43, "commercial general liability");
        $productCatalog44 = new ItemData(44, "employers liability insurance");
        $productCatalog45 = new ItemData(45, "environmental liability insurance");
        $productCatalog46 = new ItemData(46, "products liability insurance");
        $productCatalog47 = new ItemData(47, "property terrorism and sabotage insurance");
        $productCatalog48 = new ItemData(48, "business owners insurance");
        $productCatalog49 = new ItemData(49, "errors and ommissions insurance");
        $productCatalog50 = new ItemData(50, "commercial umbrella insurance");
        $productCatalog51 = new ItemData(51, "event insurance");
        $productCatalog52 = new ItemData(52, "passenger liability insurance (aviation)");
        $productCatalog53 = new ItemData(53, "ground risk hull insurance (aviation)");
        $productCatalog54 = new ItemData(54, "in-flight insurance (aviation)");
        $productCatalog55 = new ItemData(55, "roadside assistance");
        $productCatalog56 = new ItemData(56, "crop insurance");
        $productCatalog57 = new ItemData(57, "drone insurance");
        $productCatalog58 = new ItemData(58, "gap insurance");
        $productCatalog59 = new ItemData(59, "green card");
        $productCatalog60 = new ItemData(60, "orange card");
        $productCatalog61 = new ItemData(61, "Investment Saving Account (UK market related)");
        $productCatalog62 = new ItemData(62, "pension");
        $productCatalog63 = new ItemData(63, "endowment");
        $productCatalog64 = new ItemData(64, "annuity");
        $productCatalog65 = new ItemData(65, "wedding ring insurance");

        $productCatalogs = array(
            $productCatalog1,
            $productCatalog2,
            $productCatalog3,
            $productCatalog4,
            $productCatalog5,
            $productCatalog6,
            $productCatalog7,
            $productCatalog8,
            $productCatalog9,
            $productCatalog10,
            $productCatalog11,
            $productCatalog12,
            $productCatalog13,
            $productCatalog14,
            $productCatalog15,
            $productCatalog16,
            $productCatalog17,
            $productCatalog18,
            $productCatalog19,
            $productCatalog20,
            $productCatalog21,
            $productCatalog22,
            $productCatalog23,
            $productCatalog24,
            $productCatalog25,
            $productCatalog26,
            $productCatalog27,
            $productCatalog28,
            $productCatalog29,
            $productCatalog30,
            $productCatalog31,
            $productCatalog32,
            $productCatalog33,
            $productCatalog34,
            $productCatalog35,
            $productCatalog36,
            $productCatalog37,
            $productCatalog38,
            $productCatalog39,
            $productCatalog40,
            $productCatalog41,
            $productCatalog42,
            $productCatalog43,
            $productCatalog44,
            $productCatalog45,
            $productCatalog46,
            $productCatalog47,
            $productCatalog48,
            $productCatalog49,
            $productCatalog50,
            $productCatalog51,
            $productCatalog52,
            $productCatalog53,
            $productCatalog54,
            $productCatalog55,
            $productCatalog56,
            $productCatalog57,
            $productCatalog58,
            $productCatalog59,
            $productCatalog60,
            $productCatalog61,
            $productCatalog62,
            $productCatalog63,
            $productCatalog64,
            $productCatalog65
        );

        return $productCatalogs;
    }

    private function getProductModels()
    {
        $productModel0 = new ItemData(0, "conventional-annual premium");
        $productModel1 = new ItemData(1, "pay as you drive");
        $productModel2 = new ItemData(2, "pay how you drive");
        $productModel3 = new ItemData(3, "subscription (e.g. monthly fee)");
        $productModel4 = new ItemData(4, "goverment/market tarrif");
        $productModel5 = new ItemData(5, "other");

        $productModels = array(
            $productModel0,
            $productModel1,
            $productModel2,
            $productModel3,
            $productModel4,
            $productModel5
        );

        return $productModels;
    }

    private function getContractTypes()
    {
        $contractType0 = new ItemData(0, "not automated");
        $contractType1 = new ItemData(1, "smart contract");
        $contractType2 = new ItemData(2, "parametric");
        $contractType3 = new ItemData(3, "other");
        $contractTypes = array(
            $contractType0,
            $contractType1,
            $contractType2,
            $contractType3
        );

        return $contractTypes;
    }

    private function getCurrencies()
    {
        $currency0 = new ItemData(0, "fiat (ISO-4217)");
        $currency1 = new ItemData(1, "cryptocurrency and tokens (Non-ISO 4217)");

        $currencys = array(
            $currency0,
            $currency1
        );
        return $currencys;
    }

    private function getPaymentMethods()
    {
        $paymentMethod0 = new ItemData(0, "cash");
        $paymentMethod1 = new ItemData(1, "credit card");
        $paymentMethod2 = new ItemData(2, "cheque");
        $paymentMethod3 = new ItemData(3, "electronic transfer");
        $paymentMethod4 = new ItemData(4, "crypto currency or tokens");

        $paymentMethods = array(
            $paymentMethod0,
            $paymentMethod1,
            $paymentMethod2,
            $paymentMethod3,
            $paymentMethod4
        );
        return $paymentMethods;
    }

    private function getCoverages()
    {
        $coverage1 = new ItemData(1, "coverage 1");
        $coverage2 = new ItemData(2, "coverage 2");
        $coverages = array(
            $coverage1,
            $coverage2
        );
        return $coverages;
    }

    private function getSalutations()
    {
        $salutation0 = new ItemData(0, 'Mr.');
        $salutation1 = new ItemData(1, 'Mrs.');
        $salutation2 = new ItemData(2, 'Ms.');

        $salutations = array(
            $salutation0,
            $salutation1,
            $salutation2
        );

        return $salutations;
    }

    private function getSexList()
    {
        $sex0 = new ItemData('m', 'Male');
        $sex1 = new ItemData('f', 'Female');
        $sex2 = new ItemData('o', 'Other');

        $sexList = array(
            $sex0,
            $sex1,
            $sex2
        );

        return $sexList;
    }

    private function getIdTypes()
    {
        $idType0 = new ItemData(0, "Passport");
        $idType1 = new ItemData(1, "National ID");
        $idType2 = new ItemData(2, "Driving licence");
        $idType3 = new ItemData(3, "National insurance number");
        $idType4 = new ItemData(4, "Other");

        $idTypes = array(
            $idType0,
            $idType1,
            $idType2,
            $idType3,
            $idType4
        );

        return $idTypes;
    }

    private function getProducts()
    {
        // name: product.product wording
        $product1 = new ItemData(1, "Product 1");
        $product2 = new ItemData(2, "Product 2");
        $product3 = new ItemData(3, "Product 3");

        $products = array(
            $product1,
            $product2,
            $product3
        );

        return $products;
    }

    private function getBodyTypes()
    {
        $bodyType0 = new ItemData(0, "motor car");
        $bodyType1 = new ItemData(0, "motorcycle");
        $bodyType2 = new ItemData(0, "motorized tricycle");
        $bodyType3 = new ItemData(0, "electric scooter");
        $bodyType4 = new ItemData(0, "quadcycle");
        $bodyType5 = new ItemData(0, "trailer head");
        $bodyType6 = new ItemData(0, "van");
        $bodyType7 = new ItemData(0, "bus");
        $bodyType8 = new ItemData(0, "tracktor");
        $bodyType9 = new ItemData(0, "pod");
        $bodyType10 = new ItemData(0, "motor home");
        $bodyType11 = new ItemData(0, "construction equipment");

        $bodyTypes = array(
            $bodyType0,
            $bodyType1,
            $bodyType2,
            $bodyType3,
            $bodyType4,
            $bodyType5,
            $bodyType6,
            $bodyType7,
            $bodyType8,
            $bodyType9,
            $bodyType10,
            $bodyType11
        );

        return $bodyTypes;
    }

    private function getFuelTypes()
    {
        $fuelType0 = new ItemData(0, "petrol");
        $fuelType1 = new ItemData(1, "diesel");
        $fuelType2 = new ItemData(2, "electric");
        $fuelType3 = new ItemData(3, "petrol/electric hybrid");
        $fuelType4 = new ItemData(4, "gas");

        $fuelTypes = array(
            $fuelType0,
            $fuelType1,
            $fuelType2,
            $fuelType3,
            $fuelType4
        );

        return $fuelTypes;
    }

    private function getAiClassifications()
    {
        $aiClassification0 = new ItemData(0, "level 0 autonomous vehicle (SAE standard)");
        $aiClassification1 = new ItemData(1, "level 1 autonomous vehicle (SAE standard)");
        $aiClassification2 = new ItemData(2, "level 2 autonomous vehicle (SAE standard)");
        $aiClassification3 = new ItemData(3, "level 3 autonomous vehicle (SAE standard)");
        $aiClassification4 = new ItemData(4, "level 4 autonomous vehicle (SAE standard)");
        $aiClassification5 = new ItemData(5, "level 5 autonomous vehicle (SAE standard)");

        $aiClassifications = array(
            $aiClassification0,
            $aiClassification1,
            $aiClassification2,
            $aiClassification3,
            $aiClassification4,
            $aiClassification5
        );

        return $aiClassifications;
    }

    private function getVehicleUses()
    {
        $vehicleUse0 = new ItemData(0, "businees");
        $vehicleUse1 = new ItemData(1, "business and leisure");
        $vehicleUse2 = new ItemData(2, "commercial");
        $vehicleUse3 = new ItemData(3, "vehicle sharing");
        $vehicleUse4 = new ItemData(4, "vehicle subscription");

        $vehicleUses = array(
            $vehicleUse0,
            $vehicleUse1,
            $vehicleUse2,
            $vehicleUse3,
            $vehicleUse4
        );

        return $vehicleUses;
    }

    private function getWorkStatusList()
    {
        $workStatus0 = new ItemData(0, "self employed");
        $workStatus1 = new ItemData(1, "retired");
        $workStatus2 = new ItemData(2, "employed");
        $workStatus3 = new ItemData(3, "redundnt");

        $workStatusList = array(
            $workStatus0,
            $workStatus1,
            $workStatus2,
            $workStatus3
        );

        return $workStatusList;
    }

    private function getVehicles()
    {
        $vehicle1 = new ItemData(1, "123456");
        $vehicle2 = new ItemData(2, "789123");
        $vehicle3 = new ItemData(3, "456789");

        $vehicles = array(
            $vehicle1,
            $vehicle2,
            $vehicle3
        );

        return $vehicles;
    }

    private function getClaimTypes()
    {
        $claimType0 = new ItemData(0, "own property damage");
        $claimType1 = new ItemData(1, "third party bodily injury");
        $claimType2 = new ItemData(2, "third party property damage");
        $claimType3 = new ItemData(3, "other");

        $claimTypes = array(
            $claimType0,
            $claimType1,
            $claimType2,
            $claimType3
        );

        return $claimTypes;
    }

    private function getClaimStatusList()
    {
        $claimStatus0 = new ItemData(0, "open");
        $claimStatus1 = new ItemData(1, "closed");
        $claimStatus2 = new ItemData(2, "reopened");

        $claimStatusList = array(
            $claimStatus0,
            $claimStatus1,
            $claimStatus2
        );

        return $claimStatusList;
    }

    private function getPerils()
    {
        $peril0 = new ItemData(0, "liability towards third parties");
        $peril1 = new ItemData(1, "fire");
        $peril2 = new ItemData(2, "theft");
        $peril3 = new ItemData(3, "accidental damage");
        $peril4 = new ItemData(4, "windshield damage");
        $peril5 = new ItemData(5, "malicious damage");
        $peril6 = new ItemData(6, "terrorism and sabotage");
        $peril7 = new ItemData(7, "flood");
        $peril8 = new ItemData(8, "earthquake");
        $peril9 = new ItemData(9, "volcanic erruption");
        $peril10 = new ItemData(10, "tsunami");
        $peril11 = new ItemData(11, "hail");
        $peril12 = new ItemData(12, "unkown or hit and run");
        $peril13 = new ItemData(13, "riots");
        $peril14 = new ItemData(14, "strikes");
        $peril15 = new ItemData(15, "civil commotion");
        $peril16 = new ItemData(16, "war");

        $perils = array(
            $peril0,
            $peril1,
            $peril2,
            $peril3,
            $peril4,
            $peril5,
            $peril6,
            $peril7,
            $peril8,
            $peril9,
            $peril10,
            $peril11,
            $peril12,
            $peril13,
            $peril14,
            $peril15,
            $peril16
        );

        return $perils;
    }

    private function getNotifiableConditions()
    {
        $notifiableCondition0 = new ItemData(0, "diabetes");
        $notifiableCondition1 = new ItemData(1, "syncope");
        $notifiableCondition2 = new ItemData(2, "heart condition");
        $notifiableCondition3 = new ItemData(3, "sleep aponea");
        $notifiableCondition4 = new ItemData(4, "epilepsy");
        $notifiableCondition5 = new ItemData(5, "strokes");
        $notifiableCondition6 = new ItemData(6, "glaucoma");

        $notifiableConditions = array(
            $notifiableCondition0,
            $notifiableCondition1,
            $notifiableCondition2,
            $notifiableCondition3,
            $notifiableCondition4,
            $notifiableCondition5,
            $notifiableCondition6
        );

        return $notifiableConditions;
    }

    private function getBenefits()
    {
        $benefit0 = new ItemData(0, "personal accident");
        $benefit1 = new ItemData(1, "replacement vehicle");
        $benefit2 = new ItemData(2, "roadside assisstance");

        $benefits = array(
            $benefit0,
            $benefit1,
            $benefit2
        );

        return $benefits;
    }

    private function getPremiumPaymentFrequencies()
    {
        $premiumPaymentFrequency0 = new ItemData(0, "annual");
        $premiumPaymentFrequency1 = new ItemData(1, "bi-annual");
        $premiumPaymentFrequency2 = new ItemData(2, "quarterly");
        $premiumPaymentFrequency3 = new ItemData(3, "monthly");
        $premiumPaymentFrequency4 = new ItemData(4, "bi-monthly");
        $premiumPaymentFrequency5 = new ItemData(5, "weekly");
        $premiumPaymentFrequency6 = new ItemData(6, "daily");
        $premiumPaymentFrequency7 = new ItemData(7, "usage based or on demand");
        $premiumPaymentFrequency8 = new ItemData(8, "subscription (not an annual contract)");
        $premiumPaymentFrequency9 = new ItemData(9, "other");

        $premiumPaymentFrequencies = array(
            $premiumPaymentFrequency0,
            $premiumPaymentFrequency1,
            $premiumPaymentFrequency2,
            $premiumPaymentFrequency3,
            $premiumPaymentFrequency4,
            $premiumPaymentFrequency5,
            $premiumPaymentFrequency6,
            $premiumPaymentFrequency7,
            $premiumPaymentFrequency8,
            $premiumPaymentFrequency9
        );

        return $premiumPaymentFrequencies;
    }

    private function getEndorsementTypes()
    {
        $endorsementType0 = new ItemData(0, "addition/increase");
        $endorsementType1 = new ItemData(1, "deletion/decrease");
        $endorsementType2 = new ItemData(2, "policy cancellation");
        $endorsementType3 = new ItemData(3, "policy extension");
        $endorsementType4 = new ItemData(4, "policy declaration");
        $endorsementType5 = new ItemData(5, "policy transfer");
        $endorsementType6 = new ItemData(6, "policy renewal");

        $endorsementTypes = array(
            $endorsementType0,
            $endorsementType1,
            $endorsementType2,
            $endorsementType3,
            $endorsementType4,
            $endorsementType5,
            $endorsementType6
        );

        return $endorsementTypes;
    }

    private function getReceiptTypes()
    {
        $receiptType0 = new ItemData(0, "new policy");
        $receiptType1 = new ItemData(1, "policy renewal");
        $receiptType2 = new ItemData(2, "mid term adjustment");
        $receiptType3 = new ItemData(3, "claim payment");
        $receiptType4 = new ItemData(4, "brokerage payment");
        $receiptType5 = new ItemData(5, "profit share payment");
        $receiptType6 = new ItemData(6, "other");

        $receiptTypes = array(
            $receiptType0,
            $receiptType1,
            $receiptType2,
            $receiptType3,
            $receiptType4,
            $receiptType5,
            $receiptType6
        );

        return $receiptTypes;
    }

    private function getReceiptCalculations()
    {
        $receiptCalculation0 = new ItemData(0, "pro data");
        $receiptCalculation1 = new ItemData(1, "flat");

        $receiptCalculations = array(
            $receiptCalculation0,
            $receiptCalculation1
        );

        return $receiptCalculations;
    }
    
    private function getPolicyStatusList() {
        
        
        $policyStatus0 = new ItemData( 0	, "in force");
        $policyStatus1 = new ItemData(1	, "cancelled");
        $policyStatus2 = new ItemData(2	, "lapsed");
        $policyStatus3 = new ItemData(3	, "extended");
        
        $policyStatusList = array($policyStatus0,$policyStatus1,$policyStatus2,$policyStatus3);
        
        return $policyStatusList;
        
    }
    
    private function getOffenceCodes() {
        $offernceCodes = array();
        
        array_push($offernceCodes, new ItemData("AC10", "Failing to stop after an accident"));
        array_push($offernceCodes, new ItemData("AC20", "Failing to give particulars or report an accident within 24 hours"));
        array_push($offernceCodes, new ItemData("AC30", "Undefined accident offences"));
        array_push($offernceCodes, new ItemData("BA10", "Driving while disqualified by order of court"));
        array_push($offernceCodes, new ItemData("BA30", "Attempting to drive while disqualified by order of court"));
        array_push($offernceCodes, new ItemData("BA40", "Causing death by driving while disqualified"));
        array_push($offernceCodes, new ItemData("BA60", "Causing serious injury by driving while disqualified"));
        array_push($offernceCodes, new ItemData("CD10", "Driving without due care and attention"));
        array_push($offernceCodes, new ItemData("CD20", "Driving without reasonable consideration for other road users"));
        array_push($offernceCodes, new ItemData("CD30", "Driving without due care and attention or without reasonable consideration for other road users"));
        array_push($offernceCodes, new ItemData("CD40", "Causing death through careless driving when unfit through drink"));
        array_push($offernceCodes, new ItemData("CD50", "Causing death by careless driving when unfit through drugs"));
        array_push($offernceCodes, new ItemData("CD60", "Causing death by careless driving with alcohol level above the limit"));
        array_push($offernceCodes, new ItemData("CD70", "Causing death by careless driving then failing to supply a specimen for alcohol analysis"));
        array_push($offernceCodes, new ItemData("CD80", "Causing death by careless, or inconsiderate, driving"));
        array_push($offernceCodes, new ItemData("CD90", "Causing death by driving: unlicensed, disqualified or uninsured drivers"));
        array_push($offernceCodes, new ItemData("CU10", "Using a vehicle with defective brakes"));
        array_push($offernceCodes, new ItemData("CU20", "Causing or likely to cause danger by reason of use of unsuitable vehicle or using a vehicle with parts or accessories (excluding brakes, steering or tyres) in a dangerous condition"));
        array_push($offernceCodes, new ItemData("CU30", "Using a vehicle with defective tyre(s)"));
        array_push($offernceCodes, new ItemData("CU40", "Using a vehicle with defective steering"));
        array_push($offernceCodes, new ItemData("CU50", "Causing or likely to cause danger by reason of load or passengers"));
        array_push($offernceCodes, new ItemData("CU80", "Breach of requirements as to control of the vehicle, such as using a mobile phone"));
        array_push($offernceCodes, new ItemData("DD10", "Causing serious injury by dangerous driving"));
        array_push($offernceCodes, new ItemData("DD40", "Dangerous driving"));
        array_push($offernceCodes, new ItemData("DD60", "Manslaughter or culpable homicide while driving a vehicle"));
        array_push($offernceCodes, new ItemData("DD80", "Causing death by dangerous driving"));
        array_push($offernceCodes, new ItemData("DD90", "Furious driving"));
        array_push($offernceCodes, new ItemData("DR10", "Driving or attempting to drive with alcohol level above limit"));
        array_push($offernceCodes, new ItemData("DR20", "Driving or attempting to drive while unfit through drink"));
        array_push($offernceCodes, new ItemData("DR30", "Driving or attempting to drive then failing to supply a specimen for analysis"));
        array_push($offernceCodes, new ItemData("DR31", "Driving or attempting to drive then refusing to give permission for analysis of a blood sample that was taken without consent due to incapacity"));
        array_push($offernceCodes, new ItemData("DR61", "Refusing to give permission for analysis of a blood sample that was taken without consent due to incapacity in circumstances other than driving or attempting to drive"));
        array_push($offernceCodes, new ItemData("DR40", "In charge of a vehicle while alcohol level above limit"));
        array_push($offernceCodes, new ItemData("DR50", "In charge of a vehicle while unfit through drink"));
        array_push($offernceCodes, new ItemData("DR60", "Failure to provide a specimen for analysis in circumstances other than driving or attempting to drive"));
        array_push($offernceCodes, new ItemData("DR70", "Failing to co-operate with a preliminary test"));
        array_push($offernceCodes, new ItemData("DG10", "Driving or attempting to drive with drug level above the specified limit"));
        array_push($offernceCodes, new ItemData("DG60", "Causing death by careless driving with drug level above the limit"));
        array_push($offernceCodes, new ItemData("DR80", "Driving or attempting to drive when unfit through drugs"));
        array_push($offernceCodes, new ItemData("DG40", "In charge of a vehicle while drug level above specified limit"));
        array_push($offernceCodes, new ItemData("DR70", "Failing to co-operate with a preliminary test"));
        array_push($offernceCodes, new ItemData("DR90", "In charge of a vehicle when unfit through drugs"));
        array_push($offernceCodes, new ItemData("IN10", "Using a vehicle uninsured against third party risks"));
        array_push($offernceCodes, new ItemData("LC20", "Driving otherwise than in accordance with a licence"));
        array_push($offernceCodes, new ItemData("LC30", "Driving after making a false declaration about fitness when applying for a licence"));
        array_push($offernceCodes, new ItemData("LC40", "Driving a vehicle having failed to notify a disability"));
        array_push($offernceCodes, new ItemData("LC50", "Driving after a licence has been cancelled (revoked) or refused on medical grounds"));
        array_push($offernceCodes, new ItemData("MS10", "Leaving a vehicle in a dangerous position"));
        array_push($offernceCodes, new ItemData("MS20", "Unlawful pillion riding"));
        array_push($offernceCodes, new ItemData("MS30", "Play street offences"));
        array_push($offernceCodes, new ItemData("MS50", "Motor racing on the highway"));
        array_push($offernceCodes, new ItemData("MS60", "Offences not covered by other codes (including offences relating to breach of requirements as to control of vehicle)"));
        array_push($offernceCodes, new ItemData("MS70", "Driving with uncorrected defective eyesight"));
        array_push($offernceCodes, new ItemData("MS80", "Refusing to submit to an eyesight test"));
        array_push($offernceCodes, new ItemData("MS90", "Failure to give information as to identity of driver etc"));
        array_push($offernceCodes, new ItemData("MW10", "Contravention of special roads regulations (excluding speed limits)"));
        array_push($offernceCodes, new ItemData("PC10", "Undefined contravention of pedestrian crossing regulations"));
        array_push($offernceCodes, new ItemData("PC20", "Contravention of pedestrian crossing regulations with moving vehicle"));
        array_push($offernceCodes, new ItemData("PC30", "Contravention of pedestrian crossing regulations with stationary vehicle"));
        array_push($offernceCodes, new ItemData("SP10", "Exceeding goods vehicle speed limits"));
        array_push($offernceCodes, new ItemData("SP20", "Exceeding speed limit for type of vehicle (excluding goods or passenger vehicles)"));
        array_push($offernceCodes, new ItemData("SP30", "Exceeding statutory speed limit on a public road"));
        array_push($offernceCodes, new ItemData("SP40", "Exceeding passenger vehicle speed limit"));
        array_push($offernceCodes, new ItemData("SP50", "Exceeding speed limit on a motorway"));
        array_push($offernceCodes, new ItemData("TS10", "Failing to comply with traffic light signals"));
        array_push($offernceCodes, new ItemData("TS20", "Failing to comply with double white lines"));
        array_push($offernceCodes, new ItemData("TS30", "Failing to comply with ‘stop’ sign"));
        array_push($offernceCodes, new ItemData("TS40", "Failing to comply with direction of a constable/warden"));
        array_push($offernceCodes, new ItemData("TS50", "Failing to comply with traffic sign (excluding ‘stop’ signs, traffic lights or double white lines)"));
        array_push($offernceCodes, new ItemData("TS60", "Failing to comply with a school crossing patrol sign"));
        array_push($offernceCodes, new ItemData("TS70", "Undefined failure to comply with a traffic direction sign"));
        array_push($offernceCodes, new ItemData("UT50", "Aggravated taking of a vehicle"));
        array_push($offernceCodes, new ItemData("MR09", "Reckless or dangerous driving (whether or not resulting in death, injury or serious risk)"));
        array_push($offernceCodes, new ItemData("MR19", "Wilful failure to carry out the obligation placed on driver after being involved in a road accident (hit or run)"));
        array_push($offernceCodes, new ItemData("MR29", "Driving a vehicle while under the influence of alcohol or other substance affecting or diminishing the mental and physical abilities of a driver"));
        array_push($offernceCodes, new ItemData("MR39", "Driving a vehicle faster than the permitted speed"));
        array_push($offernceCodes, new ItemData("MR49", "Driving a vehicle whilst disqualified"));
        array_push($offernceCodes, new ItemData("MR59", "Other conduct constituting an offence for which a driving disqualification has been imposed by the State of Offence"));
        
        return $offernceCodes;
    }
    
}

class ItemData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}