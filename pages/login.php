
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
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logedIn'] = true;
        exit("Wilkommen weiter zum <a href='../index.php'>Blog</a>");
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}

if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
<div class="sizing">
    <form action="?login=1" method="post">
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Password:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>

        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>