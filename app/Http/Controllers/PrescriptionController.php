<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Patient;
use App\Models\Medicine;
use MongoDB\Driver\Session;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\SymtonService;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Services\PrescriptionService;
use Carbon\Carbon;


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
        $medicines = Medicine::where('medicine_amount','>',0)->get();
        $symptons = $this->symtonService->getAll();
        return view('formExamination.formExam', compact('symptons','medicines','newPrescriptionMedicine'));
    }

    public function store(PrescriptionRequest $request)
    {
        $patient_id = $this->addPatient($request);
         $prescription_id =  $this->addPrescription($request,$patient_id);
         $this->addPescriptionPatient($prescription_id);
         $message = 'Thêm đơn thuốc thành công!';
        return redirect()->route('prescription.index')->with('success',$message);
    }

    public function storeExam(PrescriptionRequest $request,$id_prescription)
    {
        $id_patient = Prescription::findOrFail($id_prescription)->id_patient;
        $patient_id = $this->updatePatient($request, $id_patient);
        $prescription_id =  $this->addPrescription($request,$patient_id,$id_prescription);
        $this->addPescriptionPatient($prescription_id);
        $message = 'Thêm đơn tái khám thành công!';
        return redirect()->route('prescription.index')->with('success',$message);

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
               $sell_mode = ($prescriptionMedicine['sell_price']==($prescriptionMedicine['unit_sell_price'])*$prescriptionMedicine['amount'])?'original':'discount';
               DB::table('prescription_medicine')->insert([
                   'id_prescrition' => $prescription_id,
                   'id_medicine' => $prescriptionMedicine['medicine']->id,
                   'amount' => $prescriptionMedicine['amount'],
                   'morning' => $prescriptionMedicine['morning'],
                   'midday' => $prescriptionMedicine['midday'],
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
                $buyAmount = $prescriptionMedicine['amount'];
               $changeMedicine = Medicine::find($prescriptionMedicine['medicine']->id);
               $amount = $changeMedicine->medicine_amount;
               $changeMedicine->medicine_amount = $amount - $buyAmount;
               $changeMedicine->save();

               $medicineLots = Lot::where('id_med',$prescriptionMedicine['medicine']->id)
               ->where('medicine_amount','>',0)
               ->orderBy('expired_date')
               ->get();
               while($buyAmount >0)
               {
               foreach($medicineLots as $medicineLot)
                {

                        $code = $medicineLot->code;
                        $medicineAmountLot = $medicineLot->medicine_amount;
                        if($buyAmount >= $medicineAmountLot)
                        {
                            $changeAmountLot = Lot::where('code',$code)->first();
                            $changeAmountLot->medicine_amount = 0;
                            $changeAmountLot->save();
                            $buyAmount = $buyAmount - $medicineAmountLot;
                        }
                        else
                        {
                            $changeAmountLot = Lot::where('code',$code)->first();
                            $amout2 = $changeAmountLot->medicine_amount;
                            $changeAmountLot->medicine_amount = $amout2 - $buyAmount;
                            $changeAmountLot->save();
                            $buyAmount = $buyAmount - $medicineAmountLot;
                        }

                }
            }

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
        $dob = $prescription->patient->dob;
        $arrayNote = $this->stringToArray($prescription->note);
        $noteValue = "";
        foreach($arrayNote as $index => $value)
        {
            if($index === 0 )
            {
                $noteValue .= $value.'<br>';
            }
            if($index % 2 === 1 )
            {

                $noteValue .= 'Tái khám lần '.$value.'    '.$arrayNote[$index+1].'<br>';
            }
        }

        $user_age = $this->calculationAge($dob);

        return view('formExamination.printForm',compact('prescription','prescription_medicines','medicineNameArr','totalPrice','user_age','noteValue'));
    }

    public function calculationAge($dob)
    {
        return Carbon::parse($dob)->diff(Carbon::now())->format('%y tuổi, %m tháng and %d ngày');
    }

    public function exportWord($id)
    {
        $prescription =  Prescription::findOrFail($id);
        $prescription_medicines = DB::table('prescription_medicine')->where('id_prescrition',$id)->get();
        $medicineNameArr = $this->getNameMedicine($prescription_medicines);
        $totalPriceMedicine  = $this->getTotalPrice($id);
        $examPrice = (int)$prescription->exam_price;
        $totalPrice = $totalPriceMedicine + $examPrice;
        $arrayNote = $this->stringToArray($prescription->note);

        $medicine = '';
        $noteValue = '';

        $templateProcessor = new TemplateProcessor('word-template/PhieuKhamBenh.docx');
        $templateProcessor->setValue('exam_date',$prescription->exam_date);
        $templateProcessor->setValue('full_name',$prescription->patient->full_name);
        $templateProcessor->setValue('guardian_name',$prescription->patient->guardian_name);
        $templateProcessor->setValue('dob',$prescription->patient->dob);
        $templateProcessor->setValue('phone',$prescription->patient->phone_number);
        $templateProcessor->setValue('gender',$prescription->patient->gender =='1'?'Nam':'Nữ');
        $templateProcessor->setValue('address',$prescription->patient->address);
        $templateProcessor->setValue('sympton',$prescription->sympton);
        $templateProcessor->setValue('prognosis',$prescription->prognosis);
        $templateProcessor->setValue('totalPrice',$totalPrice);
        foreach($arrayNote as $index => $value)
            {
                if($index === 0 )
                {
                    $noteValue .= $value.'<w:br/>';
                }
                if($index % 2 === 1 )
                {

                    $noteValue .= 'Tái khám lần '.$value.'    '.$arrayNote[$index+1].'<w:br/>';
                }
            }
        foreach($prescription_medicines as $index=> $prescription_medicine)
        {


                    $medicine .= $medicineNameArr[$index]->medicine_name.'                         SL:  '.$prescription_medicine->amount.'                              '.$prescription_medicine->number_of_day.'ngày'.'<w:br/>';


                    $medicine .= ($prescription_medicine->morning != 0)?"Sáng: ".$prescription_medicine->morning." viên ":"";
                    $medicine .= ($prescription_medicine->note_morning !== null)?$prescription_medicine->note_morning.", ":"";

                    $medicine .=  ($prescription_medicine->midday != 0)?"Trưa: ".$prescription_medicine->midday." viên ":"";
                     $medicine .= ($prescription_medicine->note_midday !== null)?$prescription_medicine->note_midday.", ":""."";

                    $medicine .=  ($prescription_medicine->afternoon != 0)?"Chiều: ".$prescription_medicine->afternoon." viên ":"";
                    $medicine .= ($prescription_medicine->note_afternoon !== null)?$prescription_medicine->note_afternoon.", ":"";

                    $medicine .= ($prescription_medicine->evening != 0)?"Tối: ".$prescription_medicine->evening." viên ":"";
                    $medicine .= ($prescription_medicine->note_evening !== null)?$prescription_medicine->note_evening:"";
                    $medicine .= "<w:br/>";

        }
        $templateProcessor->setValue('medicine',$medicine);
        $templateProcessor->setValue('note_doctor',$noteValue);



        $fileName = $prescription->patient->full_name;
        $templateProcessor->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
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

    public function stringToArray($string)
    {
        return explode(',',$string);
    }






}
