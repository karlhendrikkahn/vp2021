<?php
		//alustame sessiooni
		session_start();
		require_once("../../config.php");
		require_once("fnc_user.php");
		$author_name = "Karl-Hendrik Kahn";
		$todays_evaluation = null;
		$inserted_adjective = null;
		$adjective_error = null;
		$password_input_too_short = null;
		$password_or_email_missing = null;
		$inserted_email = null;
		
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
		$pic_num = null;
		$photo_dir = "photos/";
		$allowed_photo_types = ["image/jpeg", "image/png"];
		$all_files = array_slice(scandir($photo_dir), 2);
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
		
		if(isset($_POST["photo_select_submit"])){
		$pic_num = $_POST["photo_select"];
	}
		$pic_file_html = null;
		$pic_file = $photo_files[$pic_num];
		$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt="Tallinna Ülikool">';

		$pic_file_html = "\n <p>".$pic_file ."</p> \n";

		//fotode nimekiri
		//<p>Valida on järgmised fotod: <strong>foto1.jpg</strong>, <strong>foto2.jpg</strong>, <strong>foto3.jpg</strong>.</p> 
		//<ul>Valida on järgmised fotod: <li>foto1.jpg</li> <li>foto2.jpg</li> <li>foto3.jpg</li></ul>
		$list_html = "<ul> \n";
		for($i = 0; $i < $limit; $i ++){
			$list_html .= "<li>" .$photo_files[$i] ."</li> \n";
		}
		
	
		$list_html .= "</ul>";
		
		$photo_select_html = '<select name="photo_select">' ."\n";
		for($i = 0; $i < $limit; $i ++){
			//<option value="0">fail.jpg</option>
			$photo_select_html .= "\t \t" .'<option value="' .$i .'"';
				if($i == $pic_num){
					$photo_select_html .= " selected";
			}
			$photo_select_html .= ">" .$photo_files[$i] ."</option> \n";
				}
					$photo_select_html .= "</select> \n";
		

		//sisselogimine
			if(isset($_POST["login_submit"])){
				if(isset($_POST["email_input"]) and isset($_POST["password_input"])){
					if(!empty($_POST["email_input"]) and !empty($_POST["password_input"])){
						if(strlen($_POST["password_input"]) > 7){										
							sign_in($_POST["email_input"], $_POST["password_input"]);
						} else {
							$password_input_too_short = "Salasõna peab olema vähemalt 8 karakterit pikk!";
							$inserted_email = $_POST["email_input"];
						}
					} else {						
						$password_or_email_missing = "Puudub kasutajatunnus ja/või salasõna!";
						$inserted_email = $_POST["email_input"];
					}
				} 					
			}
			
	
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
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="email" name="email_input" placeholder="E-mail ehk kasutajatunnus" value="<?php echo $inserted_email; ?>"> 
		<input type="password" name="password_input" placeholder="Salasõna">				
		<input type="submit" name="login_submit" value="Logi sisse">		
		<span><?php echo $password_input_too_short; ?></span>
		<span><?php echo $password_or_email_missing; ?></span>		
	</form>
	
	<p>Loo endale <a href="add_user.php">kasutajakonto</a></p>
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
		<input type="submit" name="photo_select_submit" value="Näita valitud fotot">
	</form>
	<?php
		
		echo $pic_html; 
		echo $list_html;
		echo "<hr> \n";
		echo $list_html;
	?>
		
	

	
</body>
</html>