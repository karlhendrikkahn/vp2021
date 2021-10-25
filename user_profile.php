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
	require_once("fnc_user_profile.php");
	require("page_header.php");
	$notice = null;
    $user_description = read_user_description();
	
	if(isset($_POST["profile_submit"])){
		$user_description = test_input($_POST["description_input"]);

		$notice = store_user_profile($user_description, $_POST["bg_color_input"], $_POST["text_color_input"]);
		$_SESSION["bg_color"] = $_POST["bg_color_input"];
		$_SESSION["text_color"] = $_POST["text_color_input"];
	}
	
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
    <h2>Kasutajaprofiil</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="description_input">Minu lühikirjeldus</label>
		<br>
		<textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lühikirjeldus ..."><?php echo $user_description; ?></textarea>
		<br>
		<label for="bg_color_input">Taustavärv</label>
		<br>
		<input type="color" name="bg_color_input" id="bg_color_input" value="<?php echo $_SESSION["bg_color"]; ?>">
		<br>
		<label for="text_color_input">Teksti värv</label>
		<br>
		<input type="color" name="text_color_input" id="text_color_input" value="<?php echo $_SESSION["text_color"]; ?>">
		<br>
        <input type="submit" name="profile_submit" value="Salvesta">
    </form>
	
    <span><?php echo $notice; ?></span>
</body>
</html>
