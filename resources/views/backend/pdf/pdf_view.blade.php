<!DOCTYPE html>
<html>
<head>
	<title>Hi</title>
</head>
<body>

	<div class="row mt-3" id="filterData">    
        @foreach($data as $row)
            <div class="col-sm-3">
                <ul class="media-list media-list-divider m-0">
                    <li class="media">
                        <div class="media-body">
                            <div class="font-13 font-weight-bold">To.</div>
                            <div class="font-13 font-weight-bold">{{ $row->city_name ?? '' }}</div>
                            <div class="font-13 font-weight-bold">{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</div>
                            <div class="font-13 font-weight-bold">{{ $row->address ?? '' }}</div>
                            <div class="font-13 font-weight-bold">{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</div>
                            <div class="font-13 font-weight-bold">{{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
</body>
</html>