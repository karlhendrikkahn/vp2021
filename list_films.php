<?php
	$author_name = "Karl-Hendrik Kahn";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");
	$films_html = null;
	$films_html = read_all_films();
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
	
	require("page_header.php");
?>



	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<ul>
		<li><a href="http://greeny.cs.tlu.ee/~karkah/vp2021/add_films.php">Lisa filme nimekirja</a></li>
		<li><a href="http://greeny.cs.tlu.ee/~karkah/vp2021/home.php">Tagasi avalehele</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
	</ul>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
</body>
</html>