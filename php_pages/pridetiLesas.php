<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_GET['id'])){
    $prideti = $_POST['prideti'];

    if($prideti > 0) {
        $clients = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
        $client = $clients[$_GET['id']];
        $client['suma'] += $prideti;
        $clients[$_GET['id']] = $client;
        file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode($clients));
        header('Location: https://localhost/bit/3-bank/php_pages/pridetiLesas.php?id='. $_GET['id'] .'&prideta=1');
        die;
    } else {
        header('Location: https://localhost/bit/3-bank/php_pages/pridetiLesas.php?id='. $_GET['id'] .'&error=1');
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/prideti-lesas.css">
    <title>Prideti</title>
</head>

<body>
    <?php 
    define('KEY', 1);
    require 'C:/xampp/htdocs/bit/3-bank/php_components/header.php';
    ?>
    <h3>Pridėti lėšų</h3>
    <?php if(isSet($_GET['id'])){
        $clients = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
        $client = $clients[$_GET['id']];
    ?>
        <form class="prideti-form" action="" method="post">
            <div class="prideti-varas"><?php echo $client['vardas'] . ' ' . $client['pavarde']?></div>
            <div class="prideti-sask-likutis"><?php echo $client['suma']?> eur.</div>
            <input name="prideti" class="prideti-input" type="text">
            <button class="prideti-button" type="submit">Pridėti</button>
        </form>
    <?php 
    } else { ?>
        <main class="choose-main">
            <div class="choose">Prašome pasirinkti sąskaitą, kurią norite papildyti.</div>
             <a class ="saskaitu-sarasas" href="https://localhost/bit/3-bank/php_pages/saskaituSarasas.php">Sąskaitų sąrašas</a>
        </main>
    <?php 
    } 
    if (isSet($_GET['prideta'])){
    ?> 
        <div class="no-error"> Pasirinkta suma pridėta prie nurodytos sąskaitos.</div>
    <?php 
    } 
    if (isSet($_GET['error']) && $_GET['error'] == 1){
    ?> 
            <div class="error"> Minusine suma negali buti pridedama.</div>
    <?php 
    } 
    ?>
</body>
</html>