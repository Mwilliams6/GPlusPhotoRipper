<html>
<head>
	<style>
	body{
	  background-color:#bbb;
	  font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif
	}
	#bodyContent{
	  width: 90%;
    margin: 0 auto;
    border-radius: 25px;
    background-color:#ccc;
    padding: 20px;
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
	  max-width: 1120px;
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
  $re1='(picasaweb)';	# Word 1
  $re2='.*?';	# Non-greedy match on filler
  $re3='(")';	# Any Single Character 3
		preg_match_all("/".$re1.$re2.$re3."/is", $homepage, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
			if(substr_count($val[0],"/")>1 and !strrpos($val[0],"http")){
				//$formattedvalue = substr($val[0], 6);
				$formattedvalue = substr(trim($val[0]), 0, -1);
  $re5='(data)';	# Word 1
  $re6='(-)';	# Any Single Character 1
  $re7='(mk)';	# Word 2
echo "https://".$formattedvalue."<br><br>";
//$subPage = file_get_contents("https://".$formattedvalue);
				//preg_match_all("/".$re5.$re6.$re7."/is", $subPage, $subMatches, PREG_SET_ORDER);
				//foreach ($subMatches as $val2) {
				//$resultsForm=$resultsForm.$formattedvalue."<br><br>";
				//  echo $val2."<br><br>";
				//}
			}
	  }
	  //var_dump(json_decode($homepage, true));
  }
}
?>
	<div id="heading"><h1>Google+ Image Ripper</h1></div>
	<br>
	<div id="bodyContent">
		<h3>Handy image ripper for a given Google+ Profile key eg. 116749500979671626219</h3>
		<br>


		<div id="form">
		<h2>Google Plus Profile</h2>
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

		<div id="resultsForm" style="display:<?php if ($_SERVER["REQUEST_METHOD"] == "POST"){echo "block;";}else{echo "none;";}?>">
			<?php echo $resultsForm;?>
		</div>
	</div>
</body>

</html>