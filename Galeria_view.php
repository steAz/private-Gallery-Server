<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8" />
    <title>Zdobyte trofea-GALERIA</title>
    <link rel="Stylesheet" href="static/styles.css" />
    
</head>


<body>
  

    <div id="dokument">

        <div id="naglowek"></div>


        <div id="tloKolor">

       <div id="menu">
	     
                <h2>INFORMACJE</h2>
                <ol>
                    <li><a href="wyslij"><b>Wysylanie zdjec</b></a></li>
                    <li><a href="miniaturki"><b>Galeria miniaturek</b></a></li>
					 <li><a href="miniaturkiChoice"><b>Galeria miniaturek wybranych</b></a></li>
                    <li><a href="rejestracja"><b>Formularz rejestracji</b></a></li>
					<?php if(!$user['ifLogged']): ?>
                    <li><a href="logowanie"><b>Formularz logowania</b></a></li>
					<?php endif ?>
                </ol>
            </div>


            <div id="tresc">

                <h1>Glowna strona GALERII ZDJEC </h1>

                <br />
              
            </div>

   
            <br /><br /><br /><br /><br />
            <div id="footer">

                <h3 class="mail"><i><a href="mailto:kazanov18@wp.pl">Jeśli masz jakikolwiek problem, napisz</a></i></h3>
                &copy; MK

            </div>

        </div>
        </div>
       
</body>
</html>