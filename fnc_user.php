<?php
	$database = "if21_karlh_kahn";
	
	function store_new_user($name, $surname, $gender, $birth_date, $email, $password){
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		//kontrollime kas emailiga kasutaja juba eksisteerib
		$stmt = $conn->prepare("SELECT id FROM vp_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			//kasutaja juba olemas
			$notice = "Sellise tunnusega (" .$email .") kasutaja on <strong>juba olemas</strong>!";
		} else {
			//sulgen eelmise käsu
			$stmt->close();
		}
		$stmt = $conn->prepare("INSERT INTO vp_users (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		
		//Krüpteerime parooli
		$option = ["cost" => 12];
		$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
		
		$stmt->bind_param("sssiss", $name, $surname, $birth_date, $gender, $email, $pwd_hash);
		$notice = null;
		if($stmt->execute()){
			$notice = "Uus kasutaja edukalt loodud!";
		} else {
			$notice = "Uue kasutaja loomisel tekkis viga: ".$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function sign_in($email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vp_users WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			//tuli vaste, kontrollime parooli
			if(password_verify($password, $password_from_db)) {
				//Sisse logimine
				$_SESSION["user_id"] = $id_from_db;
				$_SESSION["first_name"] = $firstname_from_db;
				$_SESSION["last_name"] = $lastname_from_db;
				//kui loome ka kasutajaprofiili, siis saame teksti ja taustavärvi
				$stmt->close();
				$stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vp_userprofiles WHERE userid = ?");
				$stmt-> bind_param("i", $_SESSION["user_id"]);
				$stmt-> bind_result($bgcolor, $txtcolor);
				$stmt->execute();
				$_SESSION["text_color"] = "#000000";
				$_SESSION["bg_color"] = "#ffffff";
				if ($stmt->fetch()){
					if (!empty($bgcolor)){
						$_SESSION["bg_color"] = $bgcolor;
							
					}
					if (!empty($txtcolor)){
						$_SESSION["text_color"] = $txtcolor;
					}
				}
				
				//loeks kasutajaprofiili, kus on selle kasutaja id
				
				$stmt->close();
				$conn->close();
				header("Location: home.php");				
				exit();
			} else {
				$notice = "Kasutajatunnus või parool on vale!";
			}
		} else {
			$notice = "Kasutajatunnus või parool on vale!";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}


