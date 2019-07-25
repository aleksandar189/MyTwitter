<?php
$pdo = new PDO('mysql:host=localhost;dbname=mytwitter', 'root', '');
include('../includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../style/main.css" media="screen" />
    <title>Title</title>
</head>
<body>

<!––Navbar––>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">MyTwitter <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Blog</a>
            </li>
        </ul>
        <?php
        if(!isset($_SESSION['logedIn'])){?>
            <span class="navbar-text">
             <a class="nav-link" href="pages/login.php">Login</a>
            </span>
            <span class="navbar-text">
             <a class="nav-link" href="pages/register.php">Register</a>
            </span>
        <?php }else{?>
            <span class="navbar-text">
             <p class="nav-link">"Wilkommen <? echo $_SESSION['user_id'];?>"</p>
            </span>
        <?php } ?>
    </div>
</nav>
<!––NavbarEnd––>
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>
    <div class="sizing">
        <form action="?register=1" method="post">
            E-Mail:<br>
            <input type="email" size="40" maxlength="250" name="email"><br><br>

            Dein Passwort:<br>
            <input type="password" size="40"  maxlength="250" name="passwort"><br>

            Passwort wiederholen:<br>
            <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

            <input type="submit" value="Abschicken">
        </form>
    </div>
    <?php
} //Ende von if($showFormular)
?>
</body>
</html>
