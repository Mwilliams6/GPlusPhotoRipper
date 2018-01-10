<html>
<head>
	<style>
	body{
	  background-color:#ccc;
	  font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif
	}
	#heading{
	  --width: 365px;
    margin: 0 auto;
    text-align: center;
    border-radius: 25px;
		background: #73AD21;
		padding: 20px;
	}
	#form{
	  width: 500px;
    margin: 0 auto;
    border-radius: 15px;
		background: #ddd;
		padding: 20px;
	}
	#resultsForm{
	  width: 85%;
	  max-width: 1280px;
    margin: 0 auto;
    border-radius: 25px;
		background: #aaa;
		padding: 15px;
	}
	.error{
	  font-size:0.9em;
	  color:#ff0000;
	}
	</style>
</head>

<body>

<?php

$profileUrlErr = $resultsForm = "";
$homepage = "";

$newLookupUrl = "http://photos.googleapis.com/data/feed/api/user/";
$newUrlSuffix = "?alt=json" ;
$profileUrl;
$defaultProfile = "116749500979671626219";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["profileUrl"])) {
		$profileUrlErr = "ERROR: Profile URL is required";
	}
	else
	{
	  $profileUrlErr="";

		$profileUrl = $newLookupUrl.$_POST["profileUrl"].$newUrlSuffix;
		$homepage = file_get_contents($profileUrl);

		//echo $homepage;

		$re1='.*?';
		$re2='(url)';
		$re3='.*?';
		$re4='(".*?")';
		$re5='.*?';
		$re6='(".*?")';
		preg_match_all("/".$re2.$re3.$re4.$re5.$re6."/is", $homepage, $matches, PREG_SET_ORDER);

		foreach ($matches as $val) {
			if (strpos($val[0], 's160') !== false) {
				$formattedvalue = substr($val[0], 6);
				$formattedvalue = substr(trim($formattedvalue), 0, -3);
				$resultsForm=$resultsForm."<img src='".$formattedvalue."' height='160' width='160'>";
		  }
	  }

	  //var_dump(json_decode($homepage, true));
  }
}

?>


<div id="heading"><h1>Google+ Image Ripper</h1></div>
<h3>Handy image ripper for a given Google+ Profile key eg. 116749500979671626219</h3>



<br>

<h2>Google Plus Profile</h2>
<div id="form">
<br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
<table>
<tr>
<td>Profile URL: *</td><td><input type="text" name="profileUrl" value="<?php echo $defaultProfile; ?>" size="30"></td> <td><input type="submit" name="submit" value="Submit"></td>
</tr>
<tr>
<td></td><td><span class="error"><?php echo $profileUrlErr;?></span></td><td></td>
<tr>
</table>




</form>
</div>
<br>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" AND !empty($_POST["profileUrl"])) {echo "<h4 style='color:#FF0000;'>ripping ".$newLookupUrl.$_POST["profileUrl"].$newUrlSuffix."</h4>";}?>
<br>
<div id="resultsForm">
  <?php echo $resultsForm;?>
</div>
</body>

</html>