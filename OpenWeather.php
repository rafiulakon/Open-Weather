<?php
//Does not work for proxy servers. For this file to work remove the proxy.
	
	$text="";
	$error="";
	error_reporting(E_ERROR | E_PARSE);//For Removing Error Messages
	if(isset($_POST['submitbtn']))
	{
		$jsondata=file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".urlencode($_POST['city'])."&appid=72db5fb10e1a026ca95af5846ae0eb79");
		if($jsondata!=NULL)
		{
			$weather_data=json_decode($jsondata,true);
			if($weather_data['cod']==200)//Success
			{
				$lat=($weather_data['coord']['lat']);$lon=($weather_data['coord']['lon']);
				if($lat<0)
					$lat=((-1)*($lat))."&deg;S";
				else
					$lat=$lat."&deg;N";
				if($lon<0)
					$lon=((-1)*$lon)."&deg;W";
				else
					$lon=$lon."&deg;E";
				
				$text=$text."The Latitude and longitude of ".$_POST['city']." is ".$lat." and ".$lon.".";
				$text=$text."The Weather here is ".($weather_data['weather'][0]['description']).".";
				$text=$text."The temparature is ".($weather_data['main']['temp']-273)."&deg;C.";
				$text=$text."The maximum temparature is ".($weather_data['main']['temp_max']-273)."&deg;C and minimum temparature is ".($weather_data['main']['temp_min']-273)."&deg;C.";
				$windspeed=(($weather_data['wind']['speed'])*3600)/1000;
				$text=$text."The speed of the wind is ".$windspeed." km/h.";
				
			}
			else
			{
				$error=$error."Cannot find the city. Please try again.";
			}
		}
		else//City can't be found
		{
			$error=$error."Cannot find the city. Please try again.";
		}
		//print_r($weather_data);
	}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
	
	<!--Bootstrap file-->    
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--JQuery file-->
        <script type="text/javascript" src="jqueryfile.min.js"></script>
		<script src="jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
		
		
		<title>Open Weather</title>
	
		<style type="text/css">
		
			body
			{
				background-image:url(weather2_crop.jpg);
			}
			h1
			{
				margin-left:33%;
			}
			#city
			{
				width:50%;
				margin-left:25%;
			}
			.container
			{
				margin-top:10%;
			}
		
		</style>
	
	</head>

	
	
	<body>
	
		
		<div class="container">
			
			<h1>What's The Weather?</h1>
			
			<div class="alert alert-success" role="alert" id="success"><?php  echo($text) ?></div>
			
			<div class="alert alert-danger" role="alert" id="danger"><?php  echo($error) ?></div>
			
			<form method="POST" action="OpenWeather.php">
			
				<div class="form-group text-center">
					<label for="city"><strong>Enter the name of the City<strong></label>
					<input type="text" class="form-control" name="city" id="city" placeholder="Eg. Kolkata, New York" required>
				</div>
				
				<div class="form-group text-center">
					<button type="submit" id="submitbtn" class="btn btn-primary" name="submitbtn">Submit</button>
				</div>
				
			</form>
			
			<script>
			
				var text='<?php echo($text); ?>';
				var error='<?php echo($error); ?>';
				if(text=="")
				{
					$("#success").hide();//If text is null hide the success alert.
				}
				if(error=="")
				{
					$("#danger").hide();//If error is null hide the danger alert.
				}
			</script>
		
		</div>
	
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
	
	</body>

</html>