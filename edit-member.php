<?php 
include 'library.php';
$link = getDb(); 
//modositas
$successful_update = false;
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $telefon = mysqli_real_escape_string($link, $_POST['telefon']);
    if (!$nev) {
        die("A név nem lehe türes");
    } else {
        $query = sprintf("UPDATE tag SET nev='%s', email='%s', telefon='%s' WHERE id=%s",
                $nev, $email, $telefon, $id);

        // die($query);
        mysqli_query($link, $query) or die(mysqli_error($link));
        $successful_update = true;
    }

} else if (isset($_POST['delete'])) {
    $query1 = sprintf('DELETE FROM kolcsonzes WHERE tagid = %s', 
        mysqli_real_escape_string($link, $_POST['id']));
    $query2 = sprintf('DELETE FROM tag WHERE id = %s', 
        mysqli_real_escape_string($link, $_POST['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));
    header("Location: members.php");
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
            if (!isset($_GET['memberid'])) {
                header("Location: members.php");
                return;
            } 
            $memberid = $_GET['memberid'];
            $query = sprintf("SELECT id, nev, email, telefon FROM tag where id = %s", 
                mysqli_real_escape_string($link, $memberid));
            $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                header("Location: members.php");
                return;
            }
        ?>
        <h1>Tag adatainak módosítása</h1>
        <?php if ($successful_update): ?>
            <span class="badge badge-success">A könyvtári tag adatai sikeresen módosítva</span>
        <?php endif; ?>

        

        <form method="post" action="">
            <input type="hidden" name="id" id="id" value="<?=$memberid?>" />
            <div class="form-group">
                <label for="nev">Név</label>
                <input class="form-control" name="nev" id="nev" type="text" value="<?=$row['nev']?>" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input required class="form-control" name="email" id="email" type="text" value="<?=$row['email']?>" />
            </div>
            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input class="form-control" name="telefon" id="telefon" type="text" value="<?=$row['telefon']?>" />
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

