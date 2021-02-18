<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionRequest;
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
        $prescriptions  = Prescription::orderBy('reexam_to', 'DESC')->get();

        $tests = Prescription::groupBy('reexam_to')->select('reexam_to', DB::raw('count(*) as idx'))->orderBy('reexam_to', 'DESC')->get();
        $arrIndexByReExam = [];
        $index = 0;
        foreach ($tests as $test)
        {
            $index += $test['idx'];
            array_push($arrIndexByReExam,$index);

        }
        return view('formExamination.listExam', compact('prescriptions','arrIndexByReExam'));
    }

    public function create()
    {
        $newPrescriptionMedicine = session('PrescriptionMedicine');
        $medicines = Medicine::all();
        $symptons = $this->symtonService->getAll();
        return view('formExamination.formExam', compact('symptons','medicines','newPrescriptionMedicine'));
    }

    public function store(PrescriptionRequest $request)
    {
        $patient_id = $this->addPatient($request);
         $prescription_id =  $this->addPrescription($request,$patient_id);
         $this->addPescriptionPatient($prescription_id);
         $message = 'Thêm thành công!';
        return redirect()->route('prescription.index')->with('toast_success',$message);
    }

    public function storeExam(PrescriptionRequest $request,$id_prescription)
    {
        $id_patient = Prescription::findOrFail($id_prescription)->id_patient;
        $patient_id = $this->updatePatient($request, $id_patient);
        $prescription_id =  $this->addPrescription($request,$patient_id,$id_prescription);
        $this->addPescriptionPatient($prescription_id);
        $message = 'Thêm thành công!';
        return redirect()->route('prescription.index')->with('toast_success',$message);

    }


    public function addPrescription($request,$patient_id,$id_preexam=null)
    {
        $symptonsArr = $request->sympton_name;
        $symptonsStr= implode(',',$symptonsArr);
        $prescription  =new Prescription();
        $prescription->id_patient= $patient_id;
        $prescription->sympton = $symptonsStr;
        $prescription->prognosis = $request->prognosis;
        $prescription->exam_date = $request->exam_date;
        $prescription->exam_price = $request->exam_price;
        $noteArr = $request->note;
        $noteStr= implode(',',$noteArr);
        $prescription->note = $noteStr;
        $prescription->save();

        $prescription_id = $prescription->id;
        $prescription_change = Prescription::find($prescription_id);
        if(isset($id_preexam)){
            $prescription_time = Prescription::find($id_preexam);
            $reexam_time = $prescription_time->reexam_time;
        }
        else{
            $reexam_time =null;
        }
        $prescription_change->reexam_to = $id_preexam===null?$prescription_id:$id_preexam;

        if($reexam_time === null){
            $reexam_time =0;
        }
        else
        {
            $reexam_time++;
        }

        $prescription_change->reexam_time = $reexam_time;

        $prescription_change->save();
        return $prescription_id;




    }
    public function addPrescriptionReexam($request,$patient_id)
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
    public function updatePatient($request, $id)
    {
        $patient = Patient::find($id);
        $patient->full_name =  $request->full_name;
        $patient->phone_number = $request->phone_number;
        $patient->gender = $request->gender;
        $patient->dob  = $request->dob;
        $patient->address  = $request->address;
        $patient->guardian_name = $request->guardian_name;
        $patient->save();
        return $patient->id;
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
               $sell_mode = ($prescriptionMedicine['sell_price']==$prescriptionMedicine['calc_price'])?'original':'discount';
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
        session()->forget('PrescriptionMedicine');

    }

    public function deletePrescription($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();
        DB::table('prescription_medicine')->where('id_prescrition',$id)->delete();

        $message = 'Xóa thành công!';
        return redirect()->route('prescription.index')->with('toast_success',$message);
    }

    public function print($id)
    {
        $prescription =  Prescription::findOrFail($id);
        $prescription_medicines = DB::table('prescription_medicine')->where('id_prescrition',$id)->get();
        $medicineNameArr = $this->getNameMedicine($prescription_medicines);
        $totalPriceMedicine  = $this->getTotalPrice($id);
        $examPrice = (int)$prescription->exam_price;
        $totalPrice = $totalPriceMedicine + $examPrice;


        return view('formExamination.printForm',compact('prescription','prescription_medicines','medicineNameArr','totalPrice'));
    }
    public function getTotalPrice($id)
    {
        $totalPrice= 0;
        $prescription_medicines = DB::table('prescription_medicine')->where('id_prescrition',$id)->get();
        foreach ($prescription_medicines as $prescription_medicine){
            $totalPrice += (int)$prescription_medicine->amount * (int)$prescription_medicine->sell_price;
        }
        return $totalPrice;


    }

    public function getNameMedicine($arr)
    {
        $medicineNameArr = [];
        foreach ($arr as $i=>$v)
        {
            $medicine = Medicine::findOrFail($v->id_medicine);
            array_push($medicineNameArr,$medicine);

        }
        return $medicineNameArr;
    }

    public function reExam($id_prescription)
    {

        $id_patient = Prescription::findOrFail($id_prescription)->id_patient;
        $patient = Patient::findOrFail($id_patient);
        $prescriptions_time =  Prescription::where('reexam_to',$id_prescription)->get();
        $newPrescriptionMedicine = session('PrescriptionMedicine');


        $medicines = Medicine::all();
        $symptons = $this->symtonService->getAll();

        return view('formExamination.formExam', compact('patient','medicines','symptons','prescriptions_time','id_prescription','newPrescriptionMedicine'));
    }






}
