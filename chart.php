<?php

$fStartTime = microtime( TRUE);
// ****************************************************************************
/**
 * Nurogames SeaClouds Casestudy Sensor
 *
 * chart.php
 *
 * @author      Christian Tismer, Nurogames GmbH
 * 
 * @copyright   Copyright (c) 2015, Nurogames GmbH
 */
// ****************************************************************************

// HEADER =====================================================================
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Access-Control-Allow-Origin: *');

$sDefaultUrl = 'http://' . $_SERVER[ 'SERVER_NAME'] . dirname( $_SERVER[ 'REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
    <head>  
       
<?php

// INCLUDES ===================================================================

///////////////////////////////////////////////////////////////////////////////

$nInterval = 0 + $_REQUEST[ 'interval'];

if( $nInterval == 0)
{
     $nInterval = 65;
    //$nInterval = 600;
}

$nPrecision = 0 + $_REQUEST[ 'precision'];

if( $nPrecision == 0)
{
    $nPrecision = 19;
}

///////////////////////////////////////////////////////////////////////////////

//Debug::message( "USAGE: 'http://.../chart.php[?interval=N][&precision=N]'");


if( $_SERVER[ 'PATH_INFO'])
{
    $bAnalyticsOnly = TRUE;
}
else
{
    $bAnalyticsOnly = FALSE;
}

?>
        <title>runtime performance</title>

        
    <!-- amCharts javascript sources -->

    <script src="amcharts/amcharts_3.17.3/amcharts.js" type="text/javascript"></script>
    <script src="amcharts/amcharts_3.17.3/serial.js" type="text/javascript"></script>
    <script src="amcharts/amcharts_3.17.3/plugins/dataloader/dataloader.min.js" type="text/javascript"></script>

    <!-- Pikabu -->
    <link rel="stylesheet" href="amcharts/css/main.css">

    <!-- amCharts javascript code -->
    <!-- chart -->
    <style type="text/css">

        #hideBoxLastValue {
          width       : 10px;
          height      : 100%;
          top         : 10px;


        }

       

        #hidebox {
            width       : 100%;
            height      : 30px;
            font-size   : 11px;
            position: absolute;
            top: 350px;
        }   
    </style>
</head>

<body>
    <div class="chartdiv" id="chartdiv" >Refreshing Chart, stay tuned!</div>
    <!--div id="testdiv"></div-->
</body>        
    <script type="text/javascript">
        
    //< ?php  $akAnalytics = 20; ?>    
    //$.getJSON("analytics.php", function(obj) 
    /*
    $.getJSON("json_data.json", function(obj)
    {
        $.each(obj, function(key, value)
        {
                $("< ?php print $akAnalytics ?>").append(key.analytics);
            });
        });
   
    
    console.log("< ?php print $akAnalytics ?>");
       
     */   
     
     
//      $.ajax({
//          url: "analytics.php",
//          dataType: "json",
//          success: function(aResult){
//              $.each(aResult.result, function(key, value)
//            {
//                $("$akAnalytics").append(key.analytics);
//            });
//              console.log(aResult);
//              
//          }
//          
//      })
        
        
        
    console.log("<?php print $akAnalytics ?>");
        
    var kAjaxHttp = new XMLHttpRequest();

    function drawChartFromAjaxResponse()
    {
        if (kAjaxHttp.readyState == 4 && kAjaxHttp.status == 200)
        {
            //document.getElementById("testdiv").innerHTML = kAjaxHttp.responseText;

            var kResponse = JSON.parse( kAjaxHttp.responseText);

            AmCharts.makeChart("chartdiv",
            {
                "type": "serial",
                "pathToImages": "img/",
                "categoryField": "request_time",
                "dataDateFormat": "YYYY-MM-DD",
                "dataProvider": kResponse.result.analytics,
                "valueAxes":
                [
                    {
                        "id": "v1",
                        "title": "Avg Runtime",
                        "position": "right",
                        "titleColor": "#DD8833",
                        "color": "#DD8833",
                        "fontSize": "9",
                        "showLastLabel": true,
                        "gridAlpha": 0,
                        "axisAlpha": 1,
                        "guides": [
                                    {  // horizontal line @ 2 sec
                                        "inside": false,
                                        "value": 2, 
                                        "color": "#FF0000",
                                        "label": "2.0 QoS Limit", 
                                        "lineColor": "#FF0000",
                                        "lineAlpha": 0.8,
                                        "lineThickness": 2,
                                        "dashLength": 4
                                    },
                                    {
                                        "inside": false,
                                        "value": 1,
                                        "lineColor": "#DD8833",
                                        "lineAlpha": 0.5,
                                        "lineThickness": 1,
                                        "dashLength": 1
                                    }
                                  ]
                    }, 
                    {
                        "id": "v2",
                        "title": "Requests",
                        "position": "left",
                        "titleColor": "#1155DD",
                        "color": "#1155DD",
                        "showLastLabel": true,
                        "gridAlpha": 0,
                        "axisAlpha": 1,
                        "fontSize": "11"
                    },

                ],
                "graphs":
                [
                    {
                        "id": "AmGraph-1",
                        "valueAxis": "v1",
                        "valueField": "avg_run_time",
                        "lineColor": "#DD8833",
                        "lineThickness": "2",
                        "bullet": "round",
                        "bulletSize": 3
                    },
                    {
                        "id": "AmGraph-2",
                        "valueAxis": "v2",
                        "valueField": "requests",
                        "lineColor": "#1155DD",
                        "lineThickness": "1",
                        "dashLength": 1,
                        "bullet": "round",
                        "bulletSize": 1
                    }
                ],
                "categoryAxis":
                {
                    "title": "<?php print $sDefaultUrl;?>",
                    "markPeriodChange": false,
                    "autoGridCount": false,
                    "gridCount": 6,
                    "startOnAxis": true,
                    "showLastLabel": true,
                    "showFirstLabel": true,
                    "labelFrequency": 1,
                    "equalSpacing": true,


                    "fontSize": 9,
                    "labelRotation": 45,
                    "axisColor": "#555555",
                    "gridColor": "#555555",
                    "color": "#555555",
                    "gridAlpha": 0.5,
                    "gridThickness": 0.5,

                    "guides": kResponse.result.guides
                },
                "chartCursor":
                {
                    valueLineBalloonEnabled: true
                },
               // "legend":
               // {
               //     "useGraphSettings": true
               // },
                "titles":
                [
                    {
                        "id": "Title-20",
                        "size": 15,
                        "text": "AVG(runtime) : Requests"
                    }
                ]
            });       
        }
    };
    
    kAjaxHttp.onreadystatechange = drawChartFromAjaxResponse;

    //kAjaxHttp.open("GET", "analytics.php?interval=65&precision=19", true);
    
    kAjaxHttp.open("GET", "analytics.php", true);
    
    kAjaxHttp.send();
    
    setInterval(
        function()
        {
            kAjaxHttp.open("GET", "analytics.php", true);

            kAjaxHttp.send();
        }, 2000
    );

    </script>
</html>      
