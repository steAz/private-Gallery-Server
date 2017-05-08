<!DOCTYPE html>
<html>
<head>
    <title>Przegladanie zdjec</title>
    <link rel="Stylesheet" href="static/styles.css" />
</head>
<body>
    <h1>Przegladanie</h1>

	<form method="post">
    <?php foreach($zdjecia as $image): ?>
	<?php if(($image['wybor'] == "private" && $user['ifLogged']) || $image['wybor'] == "public"): ?>
    <?php  echo '<a href="images/' . 'znak_' . $image['nazwa'] . '"> <img src="images/' . 'miniaturka_' . $image['nazwa'] .'"></a>'; ?>
     <b>Tytul:</b> <?= $image['tytul']; echo ', '  ?>
    <b>Autor:</b>  <?= $image['autor']; ?>
	<b>Wybor:</b>  <?= $image['wybor']; ?>
	  <input type="checkbox" name="zapis[]" value="<?= $image['_id'] ?>"
	  <?php if (isset($zaznaczony) && in_array ( $image['_id'] ,  $zaznaczony)) echo "checked";	  
	  ?>
	   />
	   <?php endif ?>
    <?php endforeach ?>
	<input type="submit" name="Zapamietaj wybrane" value="Zapamietaj wybrane"/>
	 </form>  
	
      
    


</body>
</html>
