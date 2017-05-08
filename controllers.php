<?php

require_once 'business.php';


function galeria(&$model)
{
$model['user'] = uploadLoggedUser();
/*$db = get_db();
$db->images->drop();
 $db->users->drop();
 */

    return 'Galeria_view';
}


function wyslij (&$model)
{
    $image = [
        'nazwa' => null,
        'tytul' => null,
        'autor' => null,
        'wybor' => null,
        '_id' => null
        ];
  
    if($_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $upload_dir = '/var/www/dev/web/images/';
        $file = $_FILES['zdjecie'];
        $file_name =  basename($file['name']);
        $target = $upload_dir . $file_name;

        $file_nameZnakWodny = 'znak_' .  basename($file['name']);
        $targetZnakWodny = $upload_dir . $file_nameZnakWodny;

        $file_nameMiniaturka = 'miniaturka_' . basename($file['name']);
        $targetMiniaturka = $upload_dir . $file_nameMiniaturka;

        $tmp_path = $file['tmp_name'];

        czyZlyFormat();

        if ( !empty($_POST['tytul']) && !empty($_POST['autor']) && is_uploaded_file($_FILES['zdjecie']['tmp_name']))
        {
             $image = [
           'nazwa' => $_FILES['zdjecie']['name'],
           'tytul' => $_POST['tytul'],
           'autor' => $_POST['autor'],
           'wybor' => (empty($_POST['wybor']) ? "public" : $_POST['wybor'])
            ];
           
            if (move_uploaded_file($tmp_path, $target))
            {
                zapiszZdjecie(null,$image);

                if ($_FILES['zdjecie']['type'] === 'image/jpeg')
                {
                    $ob = imagecreatefromjpeg($target);
                    $szerokosc = imagesx($ob);
                    $wysokosc = imagesy($ob);

                    $szerokoscMiniaturka = 200;
                    $wysokoscMiniaturka = 125;
                    $obMiniaturka = imagecreatetruecolor($szerokoscMiniaturka, $wysokoscMiniaturka);
                    imagecopyresampled($obMiniaturka, $ob, 0, 0, 0, 0, $szerokoscMiniaturka, $wysokoscMiniaturka, $szerokosc, $wysokosc);
                    imagejpeg($obMiniaturka, $targetMiniaturka);

                    $bialy = imagecolorallocate($ob, 255, 255, 255);
                    imagestring($ob, 5, 50, 100, $_POST['znakWodny'], $bialy);
                    imagejpeg($ob, $targetZnakWodny);
                }

                elseif ($_FILES['zdjecie']['type'] === 'image/png')
                {
                    $ob = imagecreatefrompng($target);
                    $szerokosc = imagesx($ob);
                    $wysokosc = imagesy($ob);

                    $szerokoscMiniaturka = 200;
                    $wysokoscMiniaturka = 125;
                    $obMiniaturka = imagecreatetruecolor($szerokoscMiniaturka, $wysokoscMiniaturka);
                    imagecopyresampled($obMiniaturka, $ob, 0, 0, 0, 0, $szerokoscMiniaturka, $wysokoscMiniaturka, $szerokosc, $wysokosc);
                    imagepng($obMiniaturka, $targetMiniaturka);

                    $bialy = imagecolorallocate($ob, 255, 255, 255);
                    imagestring($ob, 5, 50, 100, $_POST['znakWodny'], $bialy);
                    imagepng($ob, $targetZnakWodny);
                }
            }
            
        }
        return 'redirect:galeria';

     
      
      
    }
    else
    {
    
      $model['user'] = uploadLoggedUser();
        return 'wyslij_view';
    }
 
}

function wyswietlajGalerie (&$model)
{
    $folder = opendir('/var/www/dev/web/images/');  //otwieramy folder do odczytu
    $i = 0;

    while(($plik = readdir($folder)) !== false )
    {
        if($plik != '.' && $plik != '..' && strpos($plik, 'znak_') === false && strpos($plik, 'miniaturka_') === false)
        {
            $tabZdjec[$i] = getImage_byNazwa($plik);
                $i++;
        }
    }

    $model['zdjecia'] = $tabZdjec;

  /*  $model['test'] = getImages();

    foreach ($model['test'] as $picture)
    {
        echo $picture['autor'];
    }

    */

 /*   if (!empty($_POST['id']))
    {
        $id =$_GET['id'];

        if ($image = getImage($id))
        {
            $model['image'] = $image;
            
        }
    }
    */
    
    closedir($folder);   //zamykamy folder
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {

        $_SESSION['zapisane'] = $_POST['zapis'];
        return 'redirect:miniaturki';
    }
    
    
    if(isset($_SESSION['zapisane']))
    {
        $model['zaznaczony'] = $_SESSION['zapisane'];
    }
    
    
    $model['user'] = uploadLoggedUser();
    $model['image'] = getImages();
    return 'miniaturki_view';
}

function wyswietlajChoice (&$model)
{

   if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
         $_SESSION['zapisane'] = array_diff($_SESSION['zapisane'] , $_POST['usun'] );
         return 'redirect:miniaturkiChoice';
         }
     
   if (isset($_SESSION['zapisane']))
   { 
       $model['zapisany'] = $_SESSION['zapisane'];
       $model['zdjecia'] = getImages();
   }
      
       return 'miniaturkiChoice_view';

}


function rejestruj(&$model)
{
    $user = [
        'login' => null,
        'haslo' => null,
        'hasloRepeat' => null,
        'adresEmail' => null
         ];

    if($_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $login = $_POST['log'];
        $haslo = $_POST['pass'];
        $hasloRepeat = $_POST['passRepeat'];
        $adresEmail = $_POST['email'];



        if (empty(getUser_byLogin($login))) //sprawdzamy czy login nie jest juz w bazie
        {
            if ($haslo === $hasloRepeat)  //sprawdzamy czy hasla sie zgadzaja
            {
                $hash = password_hash($haslo, PASSWORD_DEFAULT);

                $user = [
                   'login' => $_POST['log'],
                   'haslo' => $hash,
                   'hasloRepeat' => $_POST['passRepeat'],
                   'adresEmail' => $_POST['email']
               ];

                zapiszUzytkownika(null, $user);
                
            }
            else
            {
                echo 'Hasla nie sa zgodne <br/>';
                return 'registerFailure_view';
                exit;
            }
            
        }
        else
        {
            echo 'Dany login juz istnieje <br/>';
            return 'registerFailure_view';
            exit;
        }
   
        return 'registerSuccess_view';
        exit;
    }
    else
    {
        return 'rejestracja_view';
    }
    
}

function loguj(&$model)
{
    if($_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $login = $_POST['log'];
        $haslo = $_POST['pass'];

        $user = getUser_byLogin($login);
      
        if(!empty(getUser_byLogin($login)))  //sprawdzamy, czy login istnieje
        {
          
        
            if($user !== null  && password_verify($haslo, $user['haslo'])) //sprawdzamy, czy haslo jest dobre
            {
                session_regenerate_id();
                $_SESSION['user_id'] = $user['_id'];
            }
            else
            {
                echo 'Podane haslo sie nie zgadza<br/>';
                return 'logowanie_view';
                exit;
            }
        }
        else
        {
            echo 'Podany login nie istnieje <br/>';
            return 'logowanie_view';
            exit;
        }

        return 'loggingSuccess_view';
    }
    else
    {
        return 'logowanie_view';
    }
}
   
  

   

?>