<?php

namespace App\Http\Controllers;

use App\Http\Services\PrescriptionService;
use App\Http\Services\SymtonService;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class PrescriptionController extends Controller
{
    protected $prescriptionService;
    protected $symtonService;

    public function __construct
    (
        PrescriptionService $prescriptionService,
        SymtonService $symtonService
    )
    {
        $this->prescriptionService = $prescriptionService;
        $this->symtonService = $symtonService;
    }

    public function index()
    {
        $prescriptions  = $this->prescriptionService->getAll();
        return view('formExamination.listExam', compact('prescriptions'));
    }

    public function create()
    {
        $newPrescriptionMedicine = session('PrescriptionMedicine');
        $medicines = Medicine::all();
        $symptons = $this->symtonService->getAll();
        return view('formExamination.formExam', compact('symptons','medicines','newPrescriptionMedicine'));
    }

    public function store(Request $request)
    {
        $patient_id = $this->addPatient($request);
         $prescription =  $this->addPrescription($request,$patient_id);
         $prescription_medicine = $this->addPescriptionPatient($patient_id);


    }
    public function addPrescription($request,$patient_id)
    {
        $symptonsArr = $request->sympton_name;
        $symptonsStr= implode(',',$symptonsArr);
        $prescription  =new Prescription();
        $prescription->id_patient= $patient_id;
        $prescription->sympton = $symptonsStr;
        $prescription->prognosis = $request->prognosis;
        $prescription->exam_date = $request->exam_date;
        $prescription->exam_price = $request->exam_price;
        $prescription->note = $request->note;
        $prescription->save();
        return $prescription->id;

    }

    public function addPatient($request)
    {
        $patient = new Patient();
        $patient->full_name =  $request->full_name;
        $patient->phone_number = $request->phone_number;
        $patient->gender = $request->gender;
        $patient->dob  = $request->dob;
        $patient->address  = $request->address;
        $patient->guardian_name = $request->guardian_name;
        $patient->save();
        return $patient->id;
    }

    public function addPescriptionPatient($prescription_id)
    {
        (session('PrescriptionMedicine')!== null)?$newPrescriptionMedicine = session('PrescriptionMedicine'):$newPrescriptionMedicine=null;
        if($newPrescriptionMedicine !== null)
        {
           $prescriptionMedicineArray = $newPrescriptionMedicine->items;
           foreach ($prescriptionMedicineArray as $index=>$prescriptionMedicine)
           {
               $sell_mode = ($prescriptionMedicine['sell_price']==$prescriptionMedicine['unit_sell_price'])?'original':'discount';
               DB::table('prescription_medicine')->insert([
                   'id_prescrition' => $prescription_id,
                   'id_medicine' => $prescriptionMedicine['medicine']->id,
                   'amount' => $prescriptionMedicine['amount'],
                   'morning' => $prescriptionMedicine['morning'],
                   'afternoon' => $prescriptionMedicine['afternoon'],
                   'evening' => $prescriptionMedicine['evening'],
                   'note_morning' => $prescriptionMedicine['note_morning'],
                   'note_midday' => $prescriptionMedicine['note_midday'],
                   'note_evening' => $prescriptionMedicine['note_evening'],
                   'number_of_day' => $prescriptionMedicine['number_of_day'],
                   'sell_price' => $prescriptionMedicine['sell_price'],
                   'unit_sell_price' => $prescriptionMedicine['unit_sell_price'],
                   'sell_mode' => $sell_mode
               ]);
           }

        }
    }






}
