<?php
	$author_name = "Karl-Hendrik Kahn";
	$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$full_time_now = date("d.m.Y H:i:s");
	$hour_now = date ("H");
	//echo $hour_now;
	//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
	$weekday_now = date("N");
	//echo $weekday_now;
	//$day_category = "ebamäärane";
	if($weekday_now <= 5) {
		$day_category = "Koolipäev";
		if($hour_now < 8 or $hour_now >= 23 ) {
			$hour_category = "uneaeg";
		}
		if($hour_now >=8 and $hour_now <=18 ) {
			$hour_category = "tundide aeg";
		}
		if($hour_now >18 and $hour_now <=23 ) {
			$hour_category = "vaba aeg";}
		
	} else {
		$day_category = "Puhkepäev";
		if($hour_now <9 and $hour_now >24 ) {
			$hour_category = "uneaeg";
		}
	
		if($hour_now >=9 and $hour_now <=24 ) {
		$hour_category = "vaba aeg";
		}
	
	
		
		
		
		//loeme fotode katakoogi sisu
		$photo_dir = "photos/";
		$allowed_photo_types = ["image/jpeg", "image/png"];
		$all_files = array_slice(scandir($photo_dir), 2);
		//var_dump($all_files);
		//$only_files = array_slice($all_files, 2);
		//var_dump($only_files);
		$photo_files = [];
		foreach($all_files as $file) {
			$file_info = getimagesize($photo_dir .$file);
			if(isset($file_info["mime"])) {
				if(in_array($file_info["mime"], $allowed_photo_types)){
					array_push($photo_files, $file);
					
					
				}
					
			}
			
		}
	}
		$limit = count($photo_files);
		$pic_num = mt_rand(0, $limit - 1);
		$pic_file = $all_files[$pic_num];
		//<img src="pilt.jpg" alt="Tallinna Ülikool">
		$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt=Tallinna Ülikool">';
?>


<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>

</head>
<body>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<img src="TLU-logo-pilt.jpg" alt="Tallinna Ülikooli logo" width="500">
	
	<p><i>Lehe avamise hetk: <span><?php echo $weekday_names_et [$weekday_now - 1].", ".$full_time_now . ", on " .$day_category; ?></i></span>.</p>
	<p><?php echo "Hetkel on " .$hour_category; ?></p>
	<h2>Kursusel õpime</h2>
	<ul>
		<li>HTML keelt</li>
		<li>PHP programmeerimiskeelt</li>
		<li>SQL päringukeelt</li>
	</ul>
	<?php echo $pic_html; ?>
</body>
</html>
