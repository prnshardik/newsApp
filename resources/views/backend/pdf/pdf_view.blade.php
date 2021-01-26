<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create four equal columns that floats next to each other */
        .column {
            float: left;
            width: 25%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .span{
            word-break: break-all;
        }
        .line-break {
           width: 100%;
        }
    </style>
</head>
<body>
    <div class="row">
        <?php $i=0; ?>
        @foreach($data as $row)
            <?php $page_break = ''; ?>
            <?php
                if($i != 0 && $i%4 === 0){
                    $page_break = 'display: table; clear: both; content: ""; line-break: strict;';
                }
            ?>
            <div class="column" style="<?php echo $page_break; ?>">
                <span class="span">To.</span><br/>
                <span class="span">{{ $row->city_name ?? '' }}</span><br/>
                <span class="span">{{ $row->firstname ?? '' }} {{ $row->lastname ?? '' }}</span><br/>
                <span class="span">{{ $row->address ?? '' }}</span><br/>
                <span class="span">{{ $row->city_name ?? '' }} - {{ $row->pincode ?? '' }}</span><br/>
                <span class="span">{{ $row->state_name ?? '' }} {{ $row->country_name ?? '' }}</span><br/>
            </div>
            <?php $i++; ?>
        @endforeach

    </div>
    </body>
</html>