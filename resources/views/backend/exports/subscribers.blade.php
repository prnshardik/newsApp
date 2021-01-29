<table>
    <tbody>
        @if(isset($data) && !empty($data))
            @foreach($data as $key => $val)
                <tr style="height:300px ; margin-top:5px">
                    @foreach($val as $row)
                        <td style="width:21px; height:120px">
                            <div><b>To, {{ $row->city_name ?? '' }}</b></div>
                            <br/><br/>
                            <div><b>{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</b></div>
                            <br/>
                            <div><b>{{ $row->address ?? '' }}</b></div>
                            <br/>
                            <div><b>{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</b></div>
                            <br/>
                            <div><b>{{ $row->taluka_name ?? '' }} - {{ $row->district_name ?? '' }}</b></div>
                            <br/>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        @else
            <tr>
                <td>No Data Found.</td>
            </tr>
        @endif
    </tbody>
</table>
