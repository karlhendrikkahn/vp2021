<?php
		$author_name = "Karl-Hendrik Kahn";
		$todays_evaluation = null;
		$inserted_adjective = null;
		$adjective_error = null;
		
		//kontrollin kas on klikitud submit nuppu
		if(isset($_POST["todays_adjective_input"])) {
			//echo "Salvestasid vastuse!";
			//kas midagi kirjutati?
			if(!empty($_POST["adjective_input"])){
				$todays_evaluation = "<p>Tänane päev on <strong>" .$_POST["adjective_input"] ."</strong>.</p>";
				$inserted_adjective = $_POST["adjective_input"];
			} else {
				$adjective_error = "Palun kirjuta tänase päeva kohta sobiv omadussõna!";
				
			}
			
			
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
		//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
		$limit = count($photo_files);
		$pic_num = mt_rand(0, $limit - 1);
		$pic_file = $all_files[$pic_num];
		//<img src="pilt.jpg" alt="Tallinna Ülikool">
		$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt=Tallinna Ülikool">';
		
		//fotode nimekiri
		//<p>valida on järgmised fotod: <strong>foto1.jpg</strong>, <strong>foto2.jpg</strong>, <strong>foto3.jpg</strong>.</p>
		//<ul>valida on järgmised fotod: <li>foto1.jpg</li> <li>foto2.jpg</li> <li>foto3.jpg</li>.</ul>
		$list_html = "<ul>";
		for($i = 0; $i < $limit; $i ++) {
			$list_html .= "<li>" .$photo_files[$i] ."</li>";
			
		
			
		}
		$list_html .= "</ul>";
		
		
		$photo_select_html = '<select name="photo_select">' ."\n";
		for($i = 0; $i < $limit; $i ++) {
			//<option value="0">fail.jpg</option>
			$photo_select_html .= '<option value="' .$i .'">' .$photo_files[$i] ."</option> \n";
			
		}
		$photo_select_html .= "</select> \n";
?>


<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Karl-Hendrik Kahn, veebiprogrammeerimine</title>

</head>
<body>
	<h1>Karl-Hendrik Kahn, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<form method="POST">
		<input type="text" name="adjective_input" placeholder="Omadussõna tänase kohta" value="<?php echo $inserted_adjective; ?>">
		<input type="submit" name="todays_adjective_input" value="Salvesta">
		<span><?php echo $adjective_error; ?></span>
	</form>
	<hr>
	
	
	
	<?php 
		echo $todays_evaluation;
		
	?>
	<form method="POST">
		<?php echo $photo_select_html; ?>
	</form>
	<?php
		
		echo $pic_html; 
		echo $list_html
		
	?>
	

	
</body>
</html>