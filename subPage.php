<?php

$url = "https://picasaweb.google.com/116749500979671626219/ForGretlAndBob";


		$homepage = file_get_contents($url);

		$homepage = substr($homepage,1,350);

  $re2='("canonical")';	# Double Quote String 1
  $re3='( )';	# White Space 1
  $re4='(href)';	# Word 1
  $re5='(=)';	# Any Single Character 1
  $re6='(".*?")';	# Double Quote String 2

		preg_match_all("/".$re2.$re3.$re4.$re5.$re6."/is", $homepage, $matches, PREG_SET_ORDER);

		foreach ($matches as $val) {

			$headers = get_headers(str_replace("pwa", "pwaf", substr(substr($val[0], 18), 0, -1)),1);

			$profileUrl = $headers['Location'];

			$profilePage = file_get_contents($profileUrl);

			$re7='(data)';	# Word 1
			$re8='(-)';	# Any Single Character 1
			$re9='(mk)';	# Word 2
			$re10='(=)';	# Any Single Character 1
 			$re11='(".*?")';	# Double Quote String 2

			preg_match_all("/".$re7.$re8.$re9.$re10.$re11."/is", $profilePage, $subMatches, PREG_SET_ORDER);

			foreach ($subMatches as $val2) {

			  $imageUrl = substr(substr($val2[0], 9), 0, -1);
			  $formattedImageUrl = $profileUrl."/".$imageUrl;

			  $actualImagePage = file_get_contents($formattedImageUrl);

				$re12='(img)';	# Word 1
				$re13='( )';	# Any Single Character 1
				$re14='(src)';	# Word 2
				$re15='(=)';	# Any Single Character 1
				$re16='(".*?")';	# Double Quote String 2

				preg_match_all("/".$re12.$re13.$re14.$re15.$re16."/is", $actualImagePage, $imgMatches, PREG_SET_ORDER);

$distinctImgMatches = array();

				foreach ($imgMatches as $val3) {
				  $distinctImgMatches[]="<".$val3[0].">";
				}


$result = array_unique($distinctImgMatches);
print_r($result);





			}

			//echo $headers['Location'];
		}

		//echo $homepage;


?>