<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(!file_exists('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json')){
        file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode([]));

    } 
    $_POST['suma'] = 0;
    $ID = $_POST['asmens-kodas'];
       
    $klientai = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);    
    $klientai[$ID] = $_POST;
    file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode($klientai));

    header('Location: https://localhost/bit/3-bank/php_pages/saskaitosSukurimas.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/saskaitos-sukurimas.css">
    <title>Sukurti</title>
</head>
<body>
<?php 
    define('KEY', 1);
    require 'C:/xampp/htdocs/bit/3-bank/php_components/header.php';
    ?>
    <h3 class="new-account-h">Pateikite duomenis naujos sąskaitos sukūrimui.</h3>
    <form class="new-account-form" action="" method="post">
        <div class="new-accout-data">
            <label for="vardas">Vardas</label>
            <input type="text" name="vardas" id="" required>
        </div>
        <div class="new-accout-data">
            <label for="pavarde">Pavarde</label>
            <input type="text" name="pavarde" id="" required>
        </div>
        <div class="new-accout-data">
            <label for="asmens-kodas">Asmens kodas</label>
            <input type="text" name="asmens-kodas" id="" required>
        </div>
        <?php
        $accountNum = strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9));
        $bankNum = strval(77777);
        $controlSymbols = '01';
        $IBAN = 'LT' . $controlSymbols .$bankNum . $accountNum
        ?>
        <div class="new-accout-data">
            <label for="saskaitos-numeris">Saskaitos Numeris</label>
            <input type="text" name="saskaitos-numeris" id="" value="<?php echo $IBAN ?>" readonly >
        </div>
        <button class="new-accout-button" type="submit">+</button>
    </form>
</body>
</html>