<table>
    <tbody>
        @if(isset($data) && !empty($data))
            @foreach($data as $key => $val)
                <tr style="height:300px ; margin-top:5px">
                    @foreach($val as $row)
                        <td style="width:21px; height:120px">
                            <div>
                                To.
                            </div>
                                <br/>
                            <div>
                                {{ $row->pincode }}
                            </div>
                            <br/>
                            <div>
                                {{ $row->firstname }} {{ $row->lastname }}
                            </div>
                            <br/>
                            <div>
                                {{ $row->address }}
                            </div>
                            <br/>
                            <div>
                                {{ $row->city_name }} - {{ $row->pincode }}
                            </div>

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
