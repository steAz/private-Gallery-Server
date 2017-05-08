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
	  <?php if (isset($zapisany) && in_array ( $image['_id'] ,  $zapisany)):  ?>
    <?php  echo '<a href="images/' . 'znak_' . $image['nazwa'] . '"> <img src="images/' . 'miniaturka_' . $image['nazwa'] .'"></a>'; ?>
     <b>Tytul:</b> <?= $image['tytul']; echo ', '  ?>
    <b>Autor:</b>  <?= $image['autor']; ?>
	  <input type="checkbox" name="usun[]" value="<?= $image['_id'] ?>"
	   />
	   <?php endif ?>
    <?php endforeach ?>
	<input type="submit" name="Zapamietaj wybrane" value="Usun zaznaczone z zapamietanych"/>
	 </form>  
	
      
    


</body>
</html>
