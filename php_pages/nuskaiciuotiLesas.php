<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isSet($_GET['id'])){
    $nuskaiciuoti = $_POST['nuskaiciuoti'];
    $clients = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
    $client = $clients[$_GET['id']];
    $client['suma'] -= $nuskaiciuoti;
    $clients[$_GET['id']] = $client;
    file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode($clients));
    header('Location: https://localhost/bit/3-bank/php_pages/nuskaiciuotiLesas.php?prideta=1');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/nuskaiciuoti-lesas.css">
    <title>Nuskaiciuoti</title>
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
        <form class="nuskaiciuoti-form" action="" method="post">
            <div class="nuskaiciuoti-varas"><?php echo $client['vardas'] . ' ' . $client['pavarde']?></div>
            <div class="nuskaiciuoti-sask-likutis"><?php echo $client['suma']?> eur.</div>
            <input name="nuskaiciuoti" class="nuskaiciuoti-input" type="text">
            <button class="nuskaiciuoti-button" type="submit">Nuskaičiuoti</button>
        </form>
    <?php
    } elseif (isSet($_GET['nuskaiciuota'])){
    ?> <main class="nustkaiciuota-main">
            <div class="nustkaiciuota"> Pasirinkta suma nuskaičiuota iš nurodytos sąskaitos. Norėdami vėl nuskaičiuoti pinigus, prašome pasirinkti iš sąskaitų sąrašo</div>
            <a class ="saskaitu-sarasas "href="https://localhost/bit/3-bank/php_pages/saskaituSarasas.php">Sąskaitų sąrašas</a>
        </main>
    <?php } else { ?>
        <main class="choose-main">
            <div class="choose">Prašome pasirinkti sąskaitą, iš kurios norite nuskaičiuoti pinigus.</div>
             <a class ="saskaitu-sarasas" href="https://localhost/bit/3-bank/php_pages/saskaituSarasas.php">Sąskaitų sąrašas</a>
        </main>
    <?php 
    } ?>
</body>
</html>