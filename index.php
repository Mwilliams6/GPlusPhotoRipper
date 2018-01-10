<html>
<head>
</head>

<body>

<?php

$profileUrlErr = "";
$homepage = "";

$newLookupUrl = "http://photos.googleapis.com/data/feed/api/user/";
$newUrlSuffix = "?alt=json" ;
$profileUrl;
$defaultProfile = "116749500979671626219";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["profileUrl"])) {
		$profileUrlErr = "Profile URL is required";
	}
	else
	{
		echo "<h4 style='color:#FF0000;'>ripping ".$newLookupUrl.$_POST["profileUrl"].$newUrlSuffix."</h4>";
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
				echo "<img src='".$formattedvalue."' height='160' width='160'>";
		  }
	  }

	  //var_dump(json_decode($homepage, true));
  }
}

?>


<h1>Google+ Image Ripper</h1>
<h2>Handy image ripper for a given Google+ Profile link eg. https://get.google.com/u/0/albumarchive/profile_key</h2>

<br>

<h2>Google Plus Profile</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Profile URL: <input type="text" name="profileUrl" value="<?php echo $defaultProfile; ?>" size="100">
  <span class="error">* <?php echo $profileUrlErr;?></span>

  <input type="submit" name="submit" value="Submit">
</form>

</body>

</html>