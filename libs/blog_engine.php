<?php

function sayHello() {
	echo "Hello\n\n";
}

function printAllEntries() {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli('localhost', $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	#echo "MySQL connection success<br/><br/>";

	$sql = "SELECT idEntry, title, description FROM entries";
	$result = $connection->query($sql);
	
	$post_template = '<div id="post"><div id="title">*title*</div><div id="post_description">*post_description*</div><div id="post_controls">*read_more*</div></div>';
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			#echo "id: " . $row["idEntry"] . " - " . $row["title"] . " :<br/>" . $row["content"] . "<a href='pages/blog_operations.php?mode=delete&id=" . $row['idEntry'] . "'>Usuń</a>" . "<br/><br/>";
			$post = str_replace("*title*",$row['title'], $post_template);
			$post = str_replace("*post_description*",$row['description'],$post);
			$post = str_replace("*read_more*","<div id='read_more'><a href='index.php?page=blog&post_id=" . $row['idEntry'] . "'>Czytaj więcej...</a></div>",$post);
			echo $post;
		}
	}
	else
		echo "Brak postów!";
	
	$connection->close();
}

function showComments($post_id) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	$post_id = $connection->real_escape_string($post_id);
	
	$sql = "SELECT idComment, nick, comment FROM comments WHERE idEntry = $post_id";
	$result = $connection->query($sql);
	
	$comment_template = '<div id="frame">id: *id*<div id="comment_block"><div id="nick">*nick*</div><div id="comment">*comment*</div></div></div>';
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$comment = str_replace("*nick*",$row['nick'], $comment_template);
			$comment = str_replace("*comment*",$row['comment'],$comment);
			$comment = str_replace("*id*",$row['idComment'],$comment);
			echo $comment;
		}
	}
	else
		echo "Brak komenarzy!";
	
	$connection->close();
}

function showPost($post_id) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	$post_id = $connection->real_escape_string($post_id);
	
	$sql = "SELECT idEntry, title, content FROM entries WHERE idEntry = $post_id";
	$result = $connection->query($sql);
	
	$post_template = '<div id="post"><div id="title">*title*</div><div id="post_content">*post_content*</div></div>';
	$addComment = "<form action='pages/blog_operations.php?mode=add_comment&post_id=$post_id' method='post'>
		Nick: <input type='text' name='nick'><br>
		Treść: <input type='text' name='comment'><br>
		<input type='submit' value='Wyślij'>
	</form>";
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			#echo "id: " . $row["idEntry"] . " - " . $row["title"] . " :<br/>" . $row["content"] . "<a href='pages/blog_operations.php?mode=delete&id=" . $row['idEntry'] . "'>Usuń</a>" . "<br/><br/>";
			$post = str_replace("*title*",$row['title'], $post_template);
			$post = str_replace("*post_content*",$row['content'],$post);
			echo $post;
			echo 'Komentarze:<div id="comments">';
			showComments($post_id);
			echo '</div>';
		}
		echo $addComment;
	}
	else
		echo "Post nie istnieje!!";
	
	$connection->close();
}

function addPost($in_title, $in_content, $description) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	echo "MySQL connection success<br/><br/>";
	
	$in_title = $connection->real_escape_string($in_title);
	$in_content = $connection->real_escape_string($in_content);
	$description = $connection->real_escape_string($description);
	
	$sql = "INSERT INTO entries (title, content, description) VALUES ('" . $in_title . "', '" . $in_content . "', '" . $description . "')";
	
	if ($connection->query($sql) === TRUE) {
		echo "Dodawanie posta powiodło się!<BR>";
	}
	else
		echo "Coś wybuchło podczas procesu dodawania nowych danych do bazy... ;-; INFO: " . $connection->error;
	
	$connection->close();
}

function addComment($post_id, $user, $comment) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	$post_id = $connection->real_escape_string($post_id);
	$user = $connection->real_escape_string($user);
	$comment = $connection->real_escape_string($comment);
	
	$sql = "INSERT INTO comments (nick, comment, idEntry) VALUES ('" . $user . "', '" . $comment . "', '" . $post_id . "')";
	
	if ($connection->query($sql) === TRUE) {
		echo "Dodawanie komentarza powiodło się!<BR>";
	}
	else
		echo "Coś wybuchło podczas procesu dodawania nowych danych do bazy... ;-; INFO: " . $connection->error;
	
	$connection->close();
}

function deletePost($index) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	echo "MySQL connection success<br/><br/>";
	
	$index = $connection->real_escape_string($index);
	
	$sql = "DELETE FROM entries WHERE idEntry = $index";
	
	if ($connection->query($sql) === TRUE) {
		echo "Usunięto!";
	}
	else
		echo "Coś wybuchło podczas procesu usuwania danych z bazy... ;-; INFO: " . $connection->error;
	
	$connection->close();
}

function deleteComment($index) {
	$username = "root";
	$password = "";
	$servername = "localhost";
	$dbname = "hop_blog";
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if ($connection->connect_error) {
		die("Error: " + $connection->connect_error);	
	}
	
	echo "MySQL connection success<br/><br/>";
	
	$index = $connection->real_escape_string($index);
	
	$sql = "DELETE FROM comments WHERE idComment = $index";
	
	if ($connection->query($sql) === TRUE) {
		echo "Usunięto!";
	}
	else
		echo "Coś wybuchło podczas procesu usuwania danych z bazy... ;-; INFO: " . $connection->error;
	
	$connection->close();
}

?>
