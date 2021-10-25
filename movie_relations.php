<?php

		//alustame sessiooni
	session_start();
	//kas on sisselogitud
	if(!isset($_SESSION["user_id"])){
		header("Location: page2.php");
	}
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page2.php");
	}
		
	require_once("../../config.php");
	require_once("fnc_general.php");
	require_once("fnc_film.php");
	
	$photo_upload_notice = null;
	$selected_person_for_photo = null;
	$photo_upload_notice = null;
	$role = null;
	$selected_person = null;
	$notice = null;
	$selected_movie = null;
	$selected_position = null;
	$photo_dir = "./movie_photos/";
	$file_name = null;
	$file_type = null;
	if(isset($_POST["person_for_photo_input"])){
		//var_dump($_POST);
		//var_dump($_FILES);
	
		$image_check = getimagesize($_FILES["person_for_photo_input"] ["tmp_name"]);
		if($image_check !== false){
			if($image_check["mime"] == "image/jpeg"){
				$file_type = "jpg";
			}
			if($image_check["mime"] == "image/png"){
				$file_type = "png";
			}
			if($image_check["mime"] == "image/gif"){
				$file_type = "gif";			
			}
			//teen ajatempli
			$time_stamp = microtime(1)* 10000;
			//moodustan failinime (kasutaks ees ja perekonna nime aga praegu on meil vaid inimese id)
			$file_name = $_POST["person_for_photo_input"] ."_" .$time_stamp ."." .$file_type;
			//kopeerime pildi originaalkujul vajalikku kataloogi originaalnimega
			move_uploaded_file($_FILES["person_for_photo_input"]["tmp_name"], $photo_dir .$_FILES["person_for_photo_input"]["name"] .$file_name);
			$photo_upload_notice = "Pildi üleslaadimine õnnestus!";
		} else {
			$photo_upload_notice = "Pildi üleslaadimine ebaõnnestus!";
		}
		
	}
	
	require("page_header.php");
	
	
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"] ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	
	<hr>
	<ul>
		<li><a href="http://greeny.cs.tlu.ee/~karkah/vp2021/list_films.php">Vaata filmide nimekirja</a></li>
		<li><a href="http://greeny.cs.tlu.ee/~karkah/vp2021/home.php">Tagasi avalehele</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
    <h2>Filmi info seostamine</h2>
	<h3>Film, inimene ja tema roll</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="person_input">Isik:</label>		
		<select name="person_input" id="person_input">
			<option value="" selected disabled>Vali isik</option>
			<?php echo read_all_person($selected_person); ?>		
		</select>
		
		<label for="movie_input">Film:</label>
		<select name="movie_input" id="movie_input">
			<option value="" selected disabled>Vali film</option>
			<?php echo read_all_movie($selected_movie); ?>
		</select>
		
		<label for="position_input">Amet:</label>
		<select name="position_input" id="position_input">
			<option value="" selected disabled>Vali amet</option>
			<?php echo read_all_position($selected_position); ?>
		</select>
		
		<label for="role_input">Roll:</label>
		<input type="text" name="role_input" id="role_input" placeholder="Tegelase nimi"
		value="<?php echo $role; ?>">
        <input type="submit" name="person_in_movie_submit" value="Salvesta">
    </form>
	<br>
	<h3>Filmitegelase foto</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
	enctype="multipart/form-data">
		<label for="person_input">Isik:</label>	
		<select name="person_input">
				<option value="" selected disabled>Vali isik</option>
				<?php echo read_all_person($selected_person_for_photo); ?>		
		</select>
		<label for="person_for_photo_input"> Vali pildifail! </label>
		<input type="file" name="person_for_photo_input" id="person_for_photo_input">
		<input type="submit" name="person_for_photo_input" value="Lae pilt üles">
	</form>
		<span><?php echo $photo_upload_notice ?>
			
			
			</select>
</body>
</html>
