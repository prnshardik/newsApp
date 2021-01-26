<table>
    <tbody>
        @if(isset($data) && !empty($data))
            @foreach($data as $key => $val)
                <tr>
                    @foreach($val as $row)
                        <td>
                            To.<br/>
                            {{ $row->pincode }}<br/>
                            {{ $row->firstname }} {{ $row->lastname }}<br/>
                            {{ $row->address }}<br/>
                            {{ $row->city_name }} - {{ $row->pincode }}<br/>
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
