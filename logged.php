<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>

    input{
        margin: 5px;
        width: 20vw;
    }
    main{
        display: flex;
        justify-content: center;
    }
    form{
        text-align: center;
    }
    .left{

        width: 50%;
    }
    p{
        margin: 1px;
    }
    .posts{
        border: 2px solid black;
        width: 80%;
    }
    main{
        height: 80vh;
        width: 100vw;
    }
    .right{
        overflow-y: scroll;
        height: 100%;

    }
    h3{
       text-align: center;
    }
    .con{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    </style>


    
      <main>
            <div class="left">
            <h3>Dodawanie postów:</h3>
            <form action='logged.php' method='post' enctype='multipart/form-data' id='left'>
                <textarea name='title' id='title' cols='30' rows='6' placeholder='tytuł artykułu'></textarea><br>
                <textarea name='desc' id='desc' cols='30' rows='10' placeholder='Opis artykułu'></textarea><br>
                <label>Dodaj zdjęcia: </label><br>
                <input type='file' name='fileUpload' id='fileUpload' required='required'><br>
                <input type='submit' value='Prześlij na stronę' name='submit'>
            </form>
            </div>
            <div class="right">
            <h3>Usuwanie postów:</h3>
            <form action='logged.php' method='post' enctype='multipart/form-data' id='right'>
                
                <input type="number" name="number" id="" placeholder="Wpisz numer artykułu do usunięcia">
                <input type="submit" value="Usuń ze strony" name="delSub">
                    <div class="con"><?php
                        $array = file("baza.txt");
                        $count = count($array);
                        $i = 0;
                        if($count >= 4){
                            $ii = 1;
                            while ($i <= $count - 4){
                                echo "<div class='posts'><p>Artykuł nr ".($ii)."</p><p>Tytuł: ".$array[$i]."</p><p>Opis: ".$array[$i + 1]."</p><p>Zdjęcie: ".$array[$i + 2]."</p><p>".$array[$i + 3]."</p></div>";
                                $i = $i + 4;
                                $ii = $ii + 1;
                            }
                        }
                        echo "</div>";
                    if(isset($_POST['delSub'])){
                        $num = $_POST['number'];
                        $id = $count / 4;
                        $num = $num - 1 ;
                        echo"<hr>";
                        if($num < $id){
                                $a = 0;
                                $c = 4 * $num;
                                $fileName = $array[2 + $c];
                                $dir = trim(".\img\\".$fileName."");
                                
                                unlink("$dir");
                                // unlink('C:\xampp\htdocs\chuj\img\\'.$fileName);
                                // unlink('C:\xampp\htdocs\chuj\img\es.png');
                                while ($a < 4){
                                    unset($array[$a + $c]);
                                    $a = $a +1;
                                }

                                $fp2 = fopen('baza.txt', 'w');
                                $b = 0;
                                $count2 = count($array);
                                while ($b != $count2){
                                    file_put_contents("baza.txt", $array);
                                    $b = $b + 1;
                                }
                                fclose($fp2);
                                header('Location: logged.php');
                        }else{
                            echo "<br>Podanego id nie ma w bazie";
                        }
                    }      
                    ?>
</form>
        </div>
    </main>
    <hr>

    <?php   
        session_start();

        if($_SESSION['zalogowano'] == 1){
            if(isset($_POST["submit"])){
                $directory = ".\chuj\img\ ";
                $directory = str_replace(" ", '', $directory);
                $file = $directory . basename($_FILES["fileUpload"]["name"]);
                $uploadOk = 1;
                $fileType = pathinfo($file,PATHINFO_EXTENSION);
                $check = getimagesize($_FILES["fileUpload"]["tmp_name"]);
                // czyNieFake
                if(isset($_POST["submit"])) {
                    if($check !== false) {
                        echo "";
                        $uploadOk = 1;
                    } else {
                        echo "<center>Błąd: To nie zdjęcie!</center>";
                        $uploadOk = 0;
                    }
                }
                // czyZdjęcieJużIstnieje
                if (file_exists($file)) {
                    echo "<center>Błąd: Takie zdjęcie już istnieje</center>";
                    $uploadOk = 0;
                }
                // czyFormatObsługiwany
                if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
                && $fileType != "gif" ) {
                    echo "<center>Błąd: Zły format pliku. Obsługiwane formaty: JPG, PNG, GIF</center>";
                    $uploadOk = 0;
                }
                // czyZapisano
                if ($uploadOk == 0) {
                    echo "<center>Zdjęcie nie zostało dodane!</center>";
                // upload
                } else {
                    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $file)) {
                        echo "<center><i><h4>Pomyślnie dodano artykuł</h4></i></center>";
                        $title = $_POST['title'];
                        $title = str_replace(array("\r", "\n"), '', $title);
                        $desc = $_POST['desc'];
                        $desc = str_replace(array("\r", "\n"), '', $desc);
                        $date = date("Y/m/d");
                        $img = $_FILES["fileUpload"]["name"];
                        $fp = fopen('baza.txt', 'a');
                        fwrite($fp, "$title \n$desc \n$img \n$date\n");
                        fclose($fp);
                        header('Location: logged.php');
                    } else {
                        echo "<center>Wystąpiły błędy przy dodawaniu</font></center>";
                    }
                }
            }
        }else{
            header('Location: admin.php');
        }
    ?>

    <form action="logged.php" method="post">
        <input type="submit" value="Wyloguj się" name="logOut">
    </form>

    <?php
        if(isset($_POST["logOut"])){
            header('Location: admin.php');
            $_SESSION["zalogowano"]= 0;
        }
    ?>
</body>
</html>
