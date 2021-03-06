<?php
	//include 'libs/blog_engine.php';
?>
<style> <?php include 'admin_panel.css'; ?> </style>
<div id="admin_panel">
	<h1>Admin panel</h1>
	<hr/>
	<div id="login_panel">
	<h1>Login panel</h1>
	<?php
		$form = "<form action='pages/admin_page_operations.php?mode=login' method='post'>
						Login: <input type='text' name='login'><br>
						Hasło: <input type='password' name='password'><br>
						<input type='submit' value='Loguj'>
					</form>";
		if (isset($_SESSION['type'])) {
			if ($_SESSION['type'] == 666) {
				echo 'Witaj mistrzu! <a href="pages/admin_page_operations.php?mode=logout">Wyloguj</a>';
			} else echo $form;
		} else echo $form;
	?>
	</div>
	<hr/>
	<div id="blog_part">
	<h1>Blog</h1>
	<?php
		$form_addPost = "<form id='addPostForm' action='pages/blog_operations.php?mode=add' method='post'>
						Tytuł: <input type='text' name='title'>
						<input type='submit' value='Dodaj'>
					</form>
					<textarea id='descriptionInput' name='description' form='addPostForm'>Wprowadź opis</textarea>
					<textarea id='contentInput' name='content' form='addPostForm'>Wprowadź tekst</textarea>";
		$form_removePost = "<form action='pages/blog_operations.php?mode=delete' method='post'>
						Identyfikator posta: <input type='text' name='post_id'>
						<input type='submit' value='Usuń'>
					</form>";
		$form_removeComment = "<form action='pages/blog_operations.php?mode=deleteC' method='post'>
						Identyfikator komentarza: <input type='text' name='comment_id'>
						<input type='submit' value='Usuń'>
					</form>";
		$err = "Nie jesteś zalogowany! Nic tu nie ma dla Ciebie!";
		if (isset($_SESSION['type'])) {
			if ($_SESSION['type'] == 666) {
				echo $form_addPost . "\n";
				echo $form_removePost . "\n";
				echo $form_removeComment;
			} else echo $err;
		} else echo $err;
	?>
	</div>
	<hr/>
	<div id="gallery_part">
	<h1>Galeria</h1>
	<?php
		$form_addImage = "<form id='addImageForm' action='pages/gallery_operations.php?mode=image_upload' method='post' enctype='multipart/form-data'>
						Tytuł: <input type='text' name='title'>
						Plik:  <input type='file' name='fileU' id='fileU'>
						<input type='submit' value='Dodaj'>
					</form>
					<textarea id='descriptionImg' name='descriptionImg' form='addImageForm'>Wprowadź opis</textarea>";
		$form_removeImage = "<form action='pages/gallery_operations.php?mode=image_delete' method='post'>
						Identyfikator obrazu: <input type='text' name='image_id'>
						<input type='submit' value='Usuń'>
					</form>";
		$err = "Nie jesteś zalogowany! Nic tu nie ma dla Ciebie!";
		if (isset($_SESSION['type'])) {
			if ($_SESSION['type'] == 666) {
				echo $form_addImage;
				echo $form_removeImage;
			} else echo $err;
		} else echo $err;
	?>
	</div>
</div>
