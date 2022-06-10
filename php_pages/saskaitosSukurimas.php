<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(!file_exists('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json')){
        file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode([]));
    } 
    // if(!file_exists('C:/xampp/htdocs/bit/3-bank/data/id.json')){
    //     $id = 1;
    //     file_put_contents('C:/xampp/htdocs/bit/3-bank/data/id.json', json_encode($id));
    // } else {
    //     $id = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/id.json'), true);
    //     $id++;
    //     file_put_contents('C:/xampp/htdocs/bit/3-bank/data/id.json', json_encode($id));

    }
       
    $klientai = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);   
    foreach($klientai as $item){
        if($item['asmens-kodas'] == $_POST['asmens-kodas']){
            file_put_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json', json_encode($klientai));
            header('Location: https://localhost/bit/3-bank/php_pages/saskaitosSukurimas.php?error=1');
            die;
        }
    }

    $year = $_POST['asmens-kodas'][1] . $_POST['asmens-kodas'][2];
    $month = $_POST['asmens-kodas'][3] . $_POST['asmens-kodas'][4];
    $day = $_POST['asmens-kodas'][5] . $_POST['asmens-kodas'][6];
    
    function dayRange($month ){
        if ($month == '02'){
            return range(1, 29);
        }
        else if($month == '04' || $month == '06' || $month == '09' || $month == '11') {
            return range(1, 30);
        } else {
            return range(1, 31);
        }
    }
    if(!isset($_POST['asmens-kodas'])
        || strlen($_POST['asmens-kodas']) != 11
        || !in_array($_POST['asmens-kodas'][0], range(3, 4))
        || !in_array($month, range(1, 12))
        || !in_array($day, dayRange($month)))
        {
            header('Location: https://localhost/bit/3-bank/php_pages/saskaitosSukurimas.php?error=2');
            die;
        }
    if(!isset($_POST['vardas'])
        || strlen($_POST['vardas'])< 3)
        {
            header('Location: https://localhost/bit/3-bank/php_pages/saskaitosSukurimas.php?error=3');
            die;
        }
        if(!isset($_POST['pavarde'])
        || strlen($_POST['pavarde'])< 3)
        {
            header('Location: https://localhost/bit/3-bank/php_pages/saskaitosSukurimas.php?error=4');
            die;
        }
    $ID = $_POST['asmens-kodas'];
    $_POST['suma'] = 0;
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
            do {
                $accountNum = strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9)) . strval(rand(0, 9))  . strval(rand(0, 9))  . strval(rand(0, 9)) . strval(rand(0, 9));
                $bankNum = strval(77777);
                $controlSymbols = '01';
                $IBAN = 'LT' . $controlSymbols .$bankNum . $accountNum;
                $klientai = json_decode(file_get_contents('C:/xampp/htdocs/bit/3-bank/data/saskaituData.json'), true);
                $doExist = false;
                foreach($klientai as $klientas){
                    if($klientas['saskaitos-numeris'] == $IBAN){
                        $doExist = true;
                        break;
                    }
                }
            } while (!!$doExist);
        ?>
        <div class="new-accout-data">
            <label for="saskaitos-numeris">Saskaitos Numeris</label>
            <input type="text" name="saskaitos-numeris" id="" value="<?php echo $IBAN ?>" readonly >
        </div>
        <button class="new-accout-button" type="submit">+</button>
    </form>
    <?php
    if(isset($_GET['error']) && $_GET['error'] == 1){
    ?>
        <div class="error">KLAIDA! Nurodytu asmens kodu banko sąskaita jau egzistuoja.</div>
    <?php
    }  
    if(isset($_GET['error']) && $_GET['error'] == 2){
    ?>
        <div class="error">KLAIDA! Nurodytas neteisingas asmens kodas.</div>
    <?php
    }
    if(isset($_GET['error']) && $_GET['error'] == 3){
        ?>
            <div class="error">KLAIDA! Nurodytas vardas per trumpas.</div>
        <?php
        }
     if(isset($_GET['error']) && $_GET['error'] == 4){
    ?>
        <div class="error">KLAIDA! Nurodyta pavarde pertrumpa.</div>
    <?php
    }
    ?>
</body>
</html>