<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ID = $_GET['item'];
    $klientai = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
    
    $targetElement = $klientai[$ID];
    if ($targetElement['suma'] == 0){
        unset($klientai[$ID]);
        file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode($klientai));     
        header('Location: https://localhost/bit/3-bank/php_pages/saskaituSarasas.php');
    } else {
        $_SESSION['sum-error'] = $targetElement;
        header('Location: https://localhost/bit/3-bank/php_pages/saskaituSarasas.php?sum-error=1');
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
    <link rel="stylesheet" href="../styles/saskaitu-sarasas.css">
    <title>Sarasas</title>
</head>
<body>
<?php 
    define('KEY', 1);
    require 'C:/xampp/htdocs/bit/3-bank/php_components/header.php';
    ?>
    <h3>Saskaitų sąrašas</h3>
    <main class="saraso-main">
            <div class="saraso-keys">
                <div class="saraso-key saraso-varas">Vardas</div>
                <div class="saraso-key saraso-pavarde">Pavarde</div>
                <div class="saraso-key saraso-AK">Asmens kodas</div>
                <div class="saraso-key saraso-sask-nr">Sąskaitos numeris</div>
                <div class="saraso-key saraso-sask-likutis">Sąskaitos likutis</div>
            </div>
        <?php
        $data = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
        function sortBySurname ($a, $b) {
            return $a['pavarde'] <=> $b['pavarde'];
        }
        usort($data, "sortBySurname");
    
        foreach($data as $item){
        ?>      <form class="saraso-vertes" action="https://localhost/bit/3-bank/php_pages/saskaituSarasas.php?item=<?php echo $item['asmens-kodas']?>" method="post">
                    <div class="saraso-verte saraso-varas"><?php echo $item['vardas']?></div>
                    <div class="saraso-verte saraso-pavarde"><?php echo $item['pavarde']?></div>
                    <div class="saraso-verte saraso-AK"><?php echo $item['asmens-kodas']?></div>
                    <div class="saraso-verte saraso-sask-nr"><?php echo $item['saskaitos-numeris']?></div>
                    <div class="saraso-verte saraso-sask-likutis"><?php echo $item['suma']?> eur.</div>
                    <a class="prideti-lesu" href="https://localhost/bit/3-bank/php_pages/pridetiLesas.php?id=<?php echo $item['asmens-kodas']?>">Pridėti lėšų</a>
                    <a class="nuskaiciuoti-lesu" href="https://localhost/bit/3-bank/php_pages/nuskaiciuotiLesas.php?id=<?php echo $item['asmens-kodas']?>">Nuskaičiuoti lėšas</a>
                    <button type="submit">Ištrinti</button>
                </form>
        <?php
        }
        if(isSet($_GET['sum-error'])){
        ?>
            <div class="sum-error"> KLAIDA! Kliento 
                <?php echo $_SESSION['sum-error']['vardas'] . ' '
                           . $_SESSION['sum-error']['pavarde'] . ', a.k. '
                           . $_SESSION['sum-error']['asmens-kodas'] . ', sąskaitoje '
                           . $_SESSION['sum-error']['saskaitos-numeris']
                ?> yra <?php echo $_SESSION['sum-error']['suma'] ?> eur., todėl jo sąskaita negali būti ištrinta.
            </div>
           

        <?php
        }
        ?>
    </main>
</body>
</html>