<?php
	$database = "if21_karlh_kahn";
	
	function store_user_profile($id, $user_id, $user_description, $user_bgcolor, $user_txtcolor, $user_picture) {
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("INSERT INTO vp_userprofiles (id, userid, description, bgcolor, txtcolor, picture) values(?,?,?,?,?,?) ");
		echo $conn->error;
		$stmt->bind_param("iisssi", $id, $user_id, $user_description, $user_bgcolor, $user_txtcolor, $user_picture);
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
	
	function read_user_description(){
		$success = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		
		$stmt = $conn->prepare("SELECT description FROM vp_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($description_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$success = $description_from_db;
		}
		$stmt->close();
		$conn->close();
		return $success;
	}
