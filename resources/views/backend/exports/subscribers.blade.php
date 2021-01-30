<table style="margin-left: auto; table-layout: fixed; width: 100%; margin-right: auto;">
    <tbody>
        @if(isset($data) && !empty($data))
            @foreach($data as $key => $val)
                <tr style="height:300px; margin-top:5px">
                    @foreach($val as $row)
                        <td style="width:27px; height:130px ; word-wrap: break-word ;padding-right: 2px;padding-left: 2px">
                            <div style="margin-bottom:20px"><b>To, {{ $row->city_name ?? '' }}</b></div><br/>
                            <div><b>{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</b></div><br/>
                            <div><b>{{ $row->address ?? '' }}</b></div><br/>
                            <div><b>{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</b></div><br/>
                            <div><b>{{ $row->taluka_name ?? '' }} - {{ $row->district_name ?? '' }}</b></div><br/>
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
