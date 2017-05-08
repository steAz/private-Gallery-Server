<!DOCTYPE html>
<html>
<head>
    <title>Wysylanie...</title>
    <link rel="Stylesheet" href="static/styles.css" />
</head>
<body>
    <h1>Wysylanie pliku...</h1>
    <form method="post" enctype="multipart/form-data">

        <label for="zdjecie">Zaladuj ten plik:</label>
        <input type="file" name="zdjecie" />
        <input type="submit" value="Wyslij" />
        <label>
            <span>znakWodny</span>
            <input type="text" name="znakWodny" required />
        </label>
        <label>
            <span>tytul</span>
            <input type="text" name="tytul"/>
        </label>
        <label>
            <span>autor</span>
            <input type="text" name="autor" value=" <?php if(isset($user) && $user['ifLogged']) echo $user['login'];  ?>" />
        </label>
		<label>
		<?php if(isset($user) && $user['ifLogged']):  ?>
		<span>Wybor</span>
		  <input type="radio" name="wybor" value="private"> prywatne
          <input type="radio" name="wybor" value="public" checked>publiczne
		  <?php endif ?>
		</label>

    </form>
</body>
</html>
