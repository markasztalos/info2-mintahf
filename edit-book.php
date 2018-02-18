<?php 
include 'library.php';
$link = getDb(); 
//modositas
$successful_update = false;
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $cim = mysqli_real_escape_string($link, $_POST['cim']);
    $szerzo = mysqli_real_escape_string($link, $_POST['szerzo']);
    $kiado = mysqli_real_escape_string($link, $_POST['kiado']);
    $isbn = mysqli_real_escape_string($link, $_POST['isbn']);
    $megjelenesev = mysqli_real_escape_string($link, $_POST['megjelenesev']);
    if (!$cim) {
        die('A cím nem lehet üres');
    } else {
        $query = sprintf("UPDATE konyv SET cim='%s', szerzo='%s', kiado='%s', isbn='%s', megjelenesev=%s WHERE id=%s",
                $cim, $szerzo, $kiado, $isbn, $megjelenesev, $id);

        mysqli_query($link, $query) or die(mysqli_error($link));
        $successful_update = true;
    }

} else if (isset($_POST['delete'])) {
    $query1 = sprintf('DELETE FROM kolcsonzes WHERE konyvid = %s', 
        mysqli_real_escape_string($link, $_POST['id']));
    $query2 = sprintf('DELETE FROM konyv WHERE id = %s', 
        mysqli_real_escape_string($link, $_POST['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));
    header("Location: books.php");
    return;
}


?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="library.css">
    <title>Könytár</title>
</head>
<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">
        <?php
            if (!isset($_GET['bookid'])) {
                header("Location: books.php");
                return;
            } 
            $bookid = $_GET['bookid'];
            $query = sprintf("SELECT id, isbn, cim, szerzo, kiado, megjelenesev FROM konyv where id = %s", 
                mysqli_real_escape_string($link, $bookid)) or die(mysqli_error($link));
            $eredmeny = mysqli_query($link, $query);
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                header("Location: books.php");
                return;
            }
        ?>
        <h1>Könyv adatainak módosítása</h1>
        <?php if ($successful_update): ?>
        <p>
            <span class="badge badge-success">Könyv adatai sikeresen módosítva</span>
        </p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="hidden" name="id" id="id" value="<?=$bookid?>" />
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input class="form-control" name="isbn" id="isbn" type="text" value="<?=$row['isbn']?>" />
            </div>
            <div class="form-group">
                <label for="cim">Cím</label>
                <input required class="form-control" name="cim" id="cim" type="text" value="<?=$row['cim']?>" />
            </div>
            <div class="form-group">
                <label for="szerzo">Szerző</label>
                <input class="form-control" name="szerzo" id="szerzo" type="text" value="<?=$row['szerzo']?>" />
            </div>
             <div class="form-group">
                <label for="kiado">Kiadó</label>
                <input class="form-control" name="kiado" id="kiado" type="text" value="<?=$row['kiado']?>" />
            </div>
            <div class="form-group">
                <label for="megjelenesev">Megjelenés éve</label>
                <input class="form-control" name="megjelenesev" id="megjelenesev" type="number" value="<?=$row['megjelenesev']?>" />
            </div>
            <input class="btn btn-success" name="update" type="submit" value="Mentés" />
            <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
        </form>

        <?php
            closeDb($link);
        ?>
    </div>
</body>
</html>

