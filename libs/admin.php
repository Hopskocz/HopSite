<?php
	function login($login, $passwd) {
		$username = "hopsite";
		$password = "fucky0uh4x0r";
		$servername = "localhost";
		$dbname = "hop_blog";
		
		$connection = new mysqli($servername, $username, $password, $dbname);
		
		if ($connection->connect_error) {
			die("Error: " + $connection->connect_error);	
		}
		
		$login = $connection->real_escape_string($login);
		$hash = md5($passwd);
		
		$sql = "SELECT idUser,nick,type,password FROM users WHERE password = '" . $hash . "' AND nick = '" . $login . "';";
		$result = $connection->query($sql);
		
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$_SESSION['logged'] = true;
				$_SESSION['type'] = $row['type'];
			}
		}
		else
			echo "Logowanie nie powiodło się!";
		
		$connection->close();
	}
	
	function logout() {
		session_unset();
		session_destroy();
	}
?>
