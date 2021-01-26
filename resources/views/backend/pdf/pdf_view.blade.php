<!DOCTYPE html>
<html>
    <head>
    	<title>PDF</title>
        <link href="{{ asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('backend/vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    </head>
    <body>
    <div class="container">
    	<div class="row">
            <?php 
                foreach($data as $row){
            ?>
            <div class="col-lg-4">
                <table  style="width:33% ; border: 1px">
                  <tr>
                    <td>To</td>
                  </tr>
                  <tr>
                    <td>{{ $row->city_name ?? '' }}</td>
                  </tr>
                  <tr>
                    <td>{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</td>
                  </tr>
                  <tr>
                    <td>{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</td>
                  </tr>
                  <tr>
                    <td>{{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }}</td>
                  </tr>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>
    </body>
</html>