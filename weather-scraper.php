<?php
    
    $weather = "";
    $error = "";
    
    if (array_key_exists('city', $_GET)) {  #Below gets the description or error
        
        $city = str_replace(' ', '', $_GET['city']);
        
        $file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    
            $error = "That city could not be found.";

        } else {
        
            $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
            
            $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage); # Seperates the source code of the page into two parts, before this code and after
                
            if (sizeof($pageArray) > 1) { #Checks if the code was split into two
            
                    $secondPageArray = explode('</span></span></span>', $pageArray[1]); #First occurence of code splits the code into the needed array
                
                    if (sizeof($secondPageArray) > 1) { #Checks if previous line worked

                        $weather = $secondPageArray[0]; #Refers to the description needed
                        
                    } else {
                        
                        $error = "That city could not be found.";
                        
                    }
                
            } else {
                
                    $error = "That city could not be found.";
                
            }
        
        }
        
    }


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>Weather Scraper</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
        
        <style type="text/css">   
        
            html { 
            background: url(background.jpeg) no-repeat center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
            
            body {    
            background: none;
            }
            
            .container {
            text-align: center;
            margin-top: 100px;
            width: 450px;  
            }
            
            input {
            margin: 20px 0;
            }
            
            #weather {
                margin-top:15px;
            }
            
        </style>
        
    </head>

    <body>
    
        <div class="container">
      
            <h1>What's The Weather?</h1>
            
            <form>
                <fieldset class="form-group">
                    <label for="city">Enter the name of a city.</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Eg. London, Tokyo" value = "<?php 
                                                                                                                        
                                                                                                                        if (array_key_exists('city', $_GET)) {
                                                                                                                        
                                                                                                                        echo $_GET['city']; 
                                                                                                                        
                                                                                                                        }
                                                                                                                        
                                                                                                                        ?>">
                </fieldset>
    
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        
            <div id="weather"><?php 
                
                if ($weather) {
                    
                    echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
                    
                } else if ($error) {
                    
                    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                    
                }
                
                ?>
            </div>
        </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>