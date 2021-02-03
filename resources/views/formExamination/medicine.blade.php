@foreach($newPrescriptionMedicine->items as $item)
    <tr>
        <td>{{$item['medicine']->medicine_name}}</td>
        <td>Sáng: {{$item['morning']}}-{{$item['note_morning']}},{{$item['midday']}},{{$item['note_midday']}},{{$item['afternoon']}},{{$item['note_afternoon']}},{{$item['evening']}},{{$item['note_evening']}}</td>
        <td>{{$item['number_of_day']}}</td>
        <td>{{$item['amount']}}</td>
        <td>{{$item['totalPrice']}}</td>
        <td><button id="delete" type="button" class="btn btn-danger delete" data-id="{{$item['medicine']->id}}">Xóa</button>
        </td>
    </tr>
@endforeach()
<tr>
    <td colspan="5">Tổng tiền : {{$newPrescriptionMedicine->totalPrice}}</td>
</tr>
