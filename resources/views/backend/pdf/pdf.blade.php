<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Subscriber</title>
    <style>
        .container{
            display: flex;
            flex-wrap: wrap;
        }
        .inner-div{
            padding-left: 20px;
            padding-right: 20px;
            margin-bottom: 15px;
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-sizing: border-box;
            min-width: 25%;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(isset($data) && $data->isNotEmpty())
            @foreach($data as $row)
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
                <div class="inner-div">
                    <p>
                        To <br>
                        {{ $row->city_name ?? '' }} <br>
                        {{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }} <br>
                        {{ $row->address ?? '' }} <br>
                        {{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }} <br>
                        {{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }} <br>
                    </p>
                </div>
            @endforeach
        @endif
    </div>
    <button onclick="window.print();">Print</button>

    <script>
       function printPDF() {
            var printDoc = new jsPDF();
            printDoc.fromHTML($('#pdf').get(0), 10, 10, {'width': 360});
            printDoc.autoPrint();
            printDoc.output("dataurlnewwindow"); // this opens a new popup,  after this the PDF opens the print window view but there are browser inconsistencies with how this is handled
        }
   </script>
</body>
</html>
