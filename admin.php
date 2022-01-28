<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administratora</title>
</head>
<body>
    <style>
        input{
            margin: 5px;
        }
        main{
            display: none;
            justify-content: center;
            align-items:center;
        }
        form{
            text-align: center;
        }
    </style>

    <form action="admin.php" method="post" id="#formLog">
        <p class="formLog">Logowanie do panelu administratora</p>
        <label class="formLog">Login: </label><input type="text" name="login" id="login" class="formLog"><br>
        <label class="formLog">Hasło: </label><input type="password" name="pass" id="pass" class="formLog"><br>
        <input type="submit" value="Zaloguj!" name="log" class="formLog">
    </form>

    <?php
        $zalogowano = 0;
        session_start();
        if(isset($_POST['log'])){
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $hPass = sha1($pass);
            if($login == "" || $pass == ""){
                echo "<p>Uzupełnij wszystkie pola!</p>";
                $zalogowano == 0;
            }else{
                if($login == "admin" && $hPass == "d033e22ae348aeb5660fc2140aec35850c4da997"){
                    $zalogowano = 1;
                    header('location: logged.php');
            }else{
                    echo "<p>Błędne dane</p>";
                    $zalogowano = 0;
                }
            }
        }
        $_SESSION["zalogowano"]=$zalogowano;
    ?>  
</body>
</html>