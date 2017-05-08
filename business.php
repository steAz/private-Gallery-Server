<?php



function czyJPG()
{
    if ($_FILES['zdjecie']['type'] !== 'image/jpeg')
    {
        return false;
    }
    return true;
}


function czyPNG()
{
    if ($_FILES['zdjecie']['type'] !== 'image/png')
    {
        return false;
    }

    return true;
}


function czyZlyFormat()
{
    if ($_FILES['zdjecie']['size'] > 1000000 && (czyJPG() === false) && (czyPNG() === false) )
    {
        echo 'Problem: Rozmiar pliku przekroczyl wartosc 1MB <br>';
        echo 'II problem: Plik ma zly format';
        exit;
    }

    elseif ((czyJPG() === false) && (czyPNG() === false))
    {
        echo 'Problem: plik ma zly format';
        exit;
    }

    elseif ($_FILES['zdjecie']['size'] > 1000000 )
    {
        echo 'Problem: Rozmiar pliku przekroczyl wartosc 1MB';
        exit;
    }
}

function get_db()
{
    $mongo = new MongoClient(
        "mongodb://localhost:27017/",
        [ 
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
            'db' => 'wai',
        ]);

    $db =$mongo->wai;

    return $db;
}

function getImages()
{
    $db = get_db();
    return $db->images->find();
}



function getImage($id)
{
    $db = get_db();
    return $db->images->findOne(['_id' => new MongoId($id)]);
}

function getImage_byNazwa($plik)
{
    $db= get_db();
    return $db->images->findOne(['nazwa' => $plik]);

}


function zapiszZdjecie($id, $image)
{
    $db = get_db();

    if ($id == null)
    {
        $db->images->insert($image);
    }
    else
    {
        $db->images->update(['_id' => new MongoId($id)], $image);
    }
   
    return true;
}

function getUsers()
{
    $db = get_db();
    return $db->users->find();
}

function getUser_byLogin($login)
{
    $db= get_db();
    return $db->users->findOne(['login' => $login]);
}

function getUser_byHaslo($haslo)
{
    $db= get_db();
    return $db->users->findOne(['haslo' => $haslo]);
}

function zapiszUzytkownika($id, $user)
{
    $db = get_db();

    if ($id == null)
    {
        $db->users->insert($user);
    }
    else
    {
        $db->users->update(['_id' => new MongoId($id)], $user);
    }

    return true;
}

function searchUsers()
{
    $db = get_db();

    return $db->users->findOne(['login' => new MongoRegex('/kazan/i')]);
}


function uploadLoggedUser() 
{
    $db = get_db();
    if (isset($_SESSION['user_id']))
    {
          $userLogged = $db->users->findOne(['_id' => new MongoId($_SESSION['user_id'])]);
    }
 
    if (isset($userLogged))
    {
          $user =[
             'ifLogged' => true,
             'login' => $userLogged['login']
            
                 ];
    } else
    {
    $user =[
             'ifLogged' => false
            
                 ];
    }

    
    return $user;
   
}

?>