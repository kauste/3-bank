<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!file_exists('C:/xampp/htdocs/bit/3-bank/data/membersData.json')){
        file_put_contents('C:/xampp/htdocs/bit/3-bank/data/membersData.json', json_encode([]));
    }
    $data = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/membersData.json'), true);
    $data[] = $_POST;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/signUp.css">
    <title>Sign Up</title>
</head>
<body>
<nav class="header-nav">
        <div class="nav-logo">
            <img src="../images/pig-icon.png" alt="Pig_icon"></img>
            <span>Savers bank</span>
        </div>
        <div class="sign-up nav-links">
        <a class="sign-up nav-link" href="#">Sign Up</a>
        <a class=" sign-up nav-link" href="./signIn.php">Sign In</a>
    </nav>
    <main class="sign-up-main">
        <form class="sign-up-form" action="" method="post">
            <label class="sign-up label" for="vardas">Vardas</label>
            <input class="sign-up inp" name="vardas" type="text">
            <label class="sign-up label" for="pavarde">Pavarde</label>
            <input class="sign-up inp" name="pavarde"type="text">
            <label class="sign-up label" for="slaptazodis" hash>Slaptazodis</label>
            <input class="sign-up inp" name="slaptazodis" type="text">
            <button class="sign-up btn" type="submit">Uzsiregistruoti</button>
        </form>
        <img class="piggy" src="../images/piggy.png" alt="">
    </main>
</body>
</html>