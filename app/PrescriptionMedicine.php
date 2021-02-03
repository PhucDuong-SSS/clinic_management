<?php

namespace App;

class PrescriptionMedicine
{

    public $items = [];
    public $totalPrice = 0;
    public $amount = 0;

    public function __construct($oldPrescriptionMedicine)
    {
        if($oldPrescriptionMedicine){
            $this->items = $oldPrescriptionMedicine->items;
            $this->totalPrice = $oldPrescriptionMedicine->totalPrice;
            $this->amount = $oldPrescriptionMedicine->amount;
        }
    }

    public function add($medicine,$request)
    {
        $storeItem = [
            'medicine'=>$medicine,
            'amount'=>0,
            'morning'=>0,
            'midday'=>0,
            'afternoon'=>0,
            'evening'=>0,
            'note_morning'=>'',
            'note_midday'=>'',
            'note_afternoon'=>'',
            'note_evening'=>'',
            'number_of_day'=>0,
            'sell_price'=>0,
            'unit_sell_price'=>0,
            'totalPrice'=>0,
        ];

        if(array_key_exists($medicine->id,$this->items)){
            $storeItem = $this->items[$medicine->id];
            return;
        }

        $storeItem['morning'] = (int)$request->morning;
        $storeItem['midday'] = (int)$request->midday;
        $storeItem['afternoon'] = (int)$request->afternoon;
        $storeItem['evening'] = (int)$request->evening;

        isset($storeItem['morning'])? $storeItem['note_morning'] = $request->note_morning:$storeItem['note_morning']=null;
        isset($storeItem['midday'])? $storeItem['note_midday'] = $request->note_midday:$storeItem['note_midday']=null;
        isset($storeItem['afternoon'])? $storeItem['note_afternoon'] = $request->note_afternoon:$storeItem['note_afternoon']=null;
        isset($storeItem['evening'])? $storeItem['note_evening'] = $request->note_evening:$storeItem['note_evening']=null;

        $storeItem['number_of_day'] = (int)$request->number_of_day;
        $storeItem['sell_price'] = (int)$request->sell_price;
        $storeItem['unit_sell_price'] = (int)$medicine->sell_price;
       $storeItem['amount'] = $storeItem['number_of_day']*($storeItem['morning']+$storeItem['midday']+$storeItem['afternoon']+$storeItem['evening']);
       $storeItem['totalPrice'] += $storeItem['sell_price']*$storeItem['amount'];

        $this->items[$medicine->id] = $storeItem;
      $this->amount += $storeItem['amount'];
        $this->totalPrice += $storeItem['sell_price']*$storeItem['amount'];
    }
    public function delete($id)
    {
        if(array_key_exists($id,$this->items)){
            $storeItem = $this->items[$id];
            $this->amount -= $storeItem['amount'];
            $this->totalPrice -= $storeItem['totalPrice'];
            unset($this->items[$id]);
        }
    }
//    public function decrease($medicine){
//        if(array_key_exists($medicine,$this->items)){
//            $storeItem = $this->items[$medicine];
//            $storeItem['amount']--;
//            $storeItem['totalPrice']-= $this->items[$medicine]['medicine']->price;
//            $this->items[$medicine] = $storeItem;
//            $this->amount --;
//            $this->totalPrice -= $this->items[$medicine]['medicine']->price;
//            if($storeItem['amount'] == 0){
//                unset($this->items[$medicine]);
//            }
//        }
//    }
}
