<?php

	$database = "if21_karlh_kahn";
	
	function read_all_person($selected){
		$html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		//<option value="x">Eesnimi Perekonnanimi</option>
		$stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date FROM person");
		$stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $birth_of_date_from_db);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="' .$id_from_db .'"';
			if($selected == $id_from_db){
				$html .= " selected";
			}
			$html .= ">" .$first_name_from_db ." " .$last_name_from_db ." (" .$birth_of_date_from_db .")</option> \n";
		}
		
		$stmt->close();
		$conn->close();
		return $html;
	}
	function read_all_movie($selected){
		$html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		//<option value="x">Eesnimi Perekonnanimi</option>
		$stmt = $conn->prepare("SELECT id, title, production_year FROM movie");
		$stmt->bind_result($id_from_db, $title_from_db, $production_year_from_db);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="' .$id_from_db .'"';
			if($selected == $id_from_db){
				$html .= " selected";
			}
			$html .= ">" .$title_from_db ." (" .$production_year_from_db .")</option> \n";
		}
		
		$stmt->close();
		$conn->close();
		return $html;
	}
		
		
	function read_all_position($selected){
		$html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		//<option value="x">Eesnimi Perekonnanimi</option>
		$stmt = $conn->prepare("SELECT id, position_name FROM position");
		$stmt->bind_result($id_from_db, $position_name_from_db);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="' .$id_from_db .'"';
			if($selected == $id_from_db){
				$html .= " selected";
			}
			$html .= ">" .$position_name_from_db ." </option> \n";
		}
		
		$stmt->close();
		$conn->close();
		return $html;
	}	
	
	//vana kraam
	
	function read_all_films() {
	//avan andmebaasi ühenduse
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	//määrame vajaliku kodeeringu
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("SELECT * FROM film");
	//igaks juhuks kui on vigu, väljastame need
	echo $conn->error;
	//seome tulemused muutujatega
	$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
	//käsk tuleb täita
	$stmt->execute();
	//fetch()
	//<h3>pealkiri</h3>
	//<ul>
	//<li>Valmimisaasta: 1997</li>
	//...
	//</ul>
	$films_html = null;
	//while(tingimus) {
		//mida teha
		
	//}
	
	while($stmt->fetch()) {
		$films_html .= "<h3>" .$title_from_db ."</h3> \n";
		$films_html .= "<ul> \n";
		$films_html .= "<li> Valmimisaasta: " .$year_from_db ."</li> \n";
		$films_html .= "<li> Kestus: " .$duration_from_db ."</li> \n";
		$films_html .= "<li> Žanr: " .$genre_from_db ."</li> \n";
		$films_html .= "<li> Tootja: " .$studio_from_db ."</li> \n";
		$films_html .= "<li> Režissöör: " .$director_from_db ."</li> \n";
		$films_html .= "</ul> \n";
	}
	//sulgeme SQL käsu
	$stmt->close();
	//sulgeme andmebaasi ühenduse
	$conn->close();
	return $films_html;
	}
	
	function store_film($title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input) {
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) values(?,?,?,?,?,?) ");
		echo $conn->error;
		//seon SQL käsu päris andmetega, andmetüübid: i - integer, d - decimal, s - string
		$stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input);
		$success = null;
		if($stmt->execute()) {
			$success = "Salvestamine õnnestus!";
		} else {
			$success = "Salvestamisel tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $success;
		
		
		
	}