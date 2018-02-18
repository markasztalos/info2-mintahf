<?php 
include 'library.php';
$link = getDb(); 
//modositas
$successful_update = false;
if (isset($_GET['returnCurrentDate'])) {
    $id = mysqli_real_escape_string($link, $_GET['lendingid']);
    $query = sprintf("UPDATE kolcsonzes SET vissza=curdate() WHERE id=%s",
            $id);
    mysqli_query($link, $query) or die(mysqli_error($link));
    header("Location: lendings.php");
    return;

} else if (isset($_POST['return'])) {
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $vissza = mysqli_real_escape_string($link, $_POST['vissza']);
    $query = sprintf("UPDATE kolcsonzes SET vissza='%s'WHERE id=%s",
            $vissza, $id);
    mysqli_query($link, $query) or die(mysqli_error($link));
    $successful_update = true;
} else if (isset($_POST['delete'])) {
    $query1 = sprintf('DELETE FROM kolcsonzes WHERE id = %s', 
        mysqli_real_escape_string($link, $_POST['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    header("Location: lendings.php");
    return;
} else if (isset($_GET['delete'])) {
    $query1 = sprintf('DELETE FROM kolcsonzes WHERE id = %s', 
        mysqli_real_escape_string($link, $_GET['lendingid']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    header("Location: lendings.php");
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
            if (!isset($_GET['lendingid'])) {
                die('Nincs megadva kölcsönzés azonosító');
                return;
            } 
            $lendingid = $_GET['lendingid'];
            $query = sprintf("SELECT kcs.id as id, tagid, tag.nev as tagnev, konyvid, cim, kivitel, vissza FROM kolcsonzes as kcs INNER JOIN konyv ON konyv.id = kcs.konyvid INNER JOIN tag ON tag.id = kcs.tagid where kcs.id = %s", 
                mysqli_real_escape_string($link, $lendingid));
            $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                die('Nincs ilyen azonosítójú kölcsönzés');
                return;
            }
        ?>
        <h1>Kölcsönzés adatai</h1>
        <?php if ($successful_update): ?>
        <p>
            <span class="badge badge-success">Kölcsönzés módosítva</span>
        </p>
        <?php endif; ?>
        <form method="post" action="edit-lending.php?lendingid=<?=$lendingid?>">
            <input type="hidden" name="id" id="id" value="<?=$lendingid?>" />
            <div class="form-group">
                <label for='tag'>Tag</label>
                <input id="tag" class="form-control" readonly type="text" value="<?=$row['tagnev']?>" />
            </div>

             <div class="form-group">
                <label for='konyv'>Könyv</label>
                <input class="form-control" readonly type="text" id="konyv" value="<?=$row['cim']?>" />
            </div>

             <div class="form-group">
                <label for='kivitel'>Kivitel dátuma</label>
                <input class="form-control" readonly type="date" id="kivitel"value="<?=$row['kivitel']?>" />
            </div>
            <div class="form-group">
                <label for='vissza'>Kivitel dátuma</label>
                <input class="form-control" type="date" id="vissza" name='vissza' value="<?=$row['vissza']?>" />
            </div>
            <input class="btn btn-success" name="return" type="submit" value="Visszahozas" />
            <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
        </form>

        <?php
            closeDb($link);
        ?>
    </div>
</body>
</html>

