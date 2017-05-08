<?php

require("./upsTrack.php");

$status = "";
$from = "";
$to = "";
$weight = "";
$srv = "";
$loc = "";
$num = "";


if ($_POST['target'] == 'x') {
    if (preg_match('/^[a-z\d_]{4,80}$/i', $_POST['trackingNumber'])) {
        $cleanTrackingNumber = $_POST['trackingNumber'];
        $result = upsTrack("$cleanTrackingNumber");
        $num = "Tracking Number: " . $cleanTrackingNumber;
        $status = "Status: " . $result['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['STATUS']['STATUSTYPE']['DESCRIPTION'] . "\n";
        $from = "Shipper: " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPPER']['ADDRESS']['ADDRESSLINE1'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPPER']['ADDRESS']['CITY'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPPER']['ADDRESS']['STATEPROVINCECODE'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPPER']['ADDRESS']['POSTALCODE'];
        $to = "Shipped To: " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPTO']['ADDRESS']['ADDRESSLINE1'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPTO']['ADDRESS']['CITY'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPTO']['ADDRESS']['STATEPROVINCECODE'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPTO']['ADDRESS']['POSTALCODE'];
        $weight = "Weight: " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPMENTWEIGHT']['WEIGHT'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['SHIPMENTWEIGHT']['UNITOFMEASUREMENT']['CODE'];
        $srv = "Service: " . $result['TRACKRESPONSE']['SHIPMENT']['SERVICE']['DESCRIPTION'];
        $loc = "Current Location: " . $result['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['ACTIVITYLOCATION']['ADDRESS']['CITY'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['ACTIVITYLOCATION']['ADDRESS']['STATEPROVINCECODE'] . " " . $result['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['ACTIVITYLOCATION']['ADDRESS']['POSTALCODE'];
        //echo '<pre>'; print_r($result); echo '</pre>';
    } else {
            echo 'Invalid tracking number.';
    }
}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>UPS Track Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Add a gray background color and some padding to the footer */
            footer {
                color: white;
                background-color: #101010;
                padding: 15px;
                bottom: 0%;
                position: relative;
                width: 100%;
            }
            
            hr {
                margin-top: 5px;
                margin-bottom: 5px;
            }
            
            .btn-group {
                margin-top: 5px;
            }
            
            .panel .panel-primary {
                margin-bottom: 100px;
            }

            .carousel-inner img {
                width: 100%; /* Set width to 100% */
                margin: auto;
                min-height:200px;
            }

            /* Hide the carousel text when the screen is less than 600 pixels wide */
            @media (max-width: 600px) {
                .carousel-caption {
                    display: none; 
                }
            }
        </style>
    </head>
    <body>
        
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="index.php">UPS Track</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">UPS Demo</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">    
            <br>
            <div class="row"><br></div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">UPS Track</div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                  <label for="trackNum">Tracking Number:</label>
                                  <input type="text" name="trackingNumber" class="form-control" id="trackNum">
                                  <input type="hidden" name="target" value="x" />
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                            <p>
                                <?php
                                echo $num . "<br>";
                                echo $to . "<br>";
                                echo $from . "<br>";
                                echo $weight . "<br>";
                                echo $srv . "<br>";
                                echo $loc . "<br>";
                                echo $status . "<br>";
                                ?>
                            </p>
                        </div>
                    </div>
                    <!--
                    <div class="panel panel-primary">
                        <div class="panel-heading">UPS Rate Estimate</div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                <label for="from">From City:</label>
                                <input type="text" name="from" class="form-control" id="from">
                                <label for="from">To City:</label>
                                <input type="text" name="to" class="form-control" id="to">
                                <label for="svc">Service:</label>
                                <select name="svc" class="form-control" id="svc">
                                    <option value="ground">Ground</option>
                                    <option value="2da">2nd Day Air</option>
                                    <option value="nda">Next Day Air</option>
                                </select>
                                <input type="hidden" name="target" value="x" />
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>Created by Joshua Alexander, UPS PHP code from <a href="https://www.marksanborn.net/php/tracking-ups-packages-with-php/ ">Mark Sanborn</a>.</p>
        </footer>

    </body>
</html>