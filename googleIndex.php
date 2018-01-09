<html>
<head>
</head>

<body>

<?php
// define variables and set to empty values
$profileUrlErr = "";
$homepage = "";
$profileUrl = "https://get.google.com/u/0/albumarchive/<PROFILE_URL>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["profileUrl"])) {
    $profileUrlErr = "Profile URL is required";
  }

echo "<h4 style='color:FF0000;'>ripping " . $_POST["profileUrl"] . "</h4>";
$profileUrl = $_POST["profileUrl"];
if(substr( $profileUrl, 0, 40 ) === "https://get.google.com/u/0/albumarchive/")
{
  $homepage = file_get_contents($_POST["profileUrl"]);

  //find matches of './albumarchive/<PROFILE_URL>/albums/'
  $re2='(")';	# Any Single Character 1
  $re3='(\\.)';	# Any Single Character 2
  $re4='(\\/)';	# Any Single Character 3
  $re5='(albumarchive)';	# Word 1
  $re6='(\\/)';	# Any Single Character 4
  $re7='.*?';	# Non-greedy match on filler
  $re8='(")';	# Any Single Character 5

  preg_match_all("/".$re2.$re3.$re4.$re5.$re6.$re7.$re8."/is", $homepage, $output_array);

 print_r($output_array);
}
else
{
  echo "<h4>Bad URL (should start 'https://get.google.com/u/0/albumarchive/....')" . $_POST["profileUrl"] . "</h4>";
}


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<h1>Google+ Image Ripper</h1>
<h2>Handy image ripper for a given Google+ Profile link eg. https://get.google.com/u/0/albumarchive/<profile_key></h2>

</br>

<h2>Google Plus Profile</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Profile URL: <input type="text" name="profileUrl" value="<?php echo $profileUrl;?>" size="100">
  <span class="error">* <?php echo $profileUrlErr;?></span>

  <input type="submit" name="submit" value="Submit">
</form>
</body>

</html>