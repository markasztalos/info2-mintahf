<?php
include 'library.php';
$link = getDb(); 

$create = false;
if (isset($_POST['create'])) {
    $tagid = mysqli_real_escape_string($link, $_POST['tagid']);
    $konyvid = mysqli_real_escape_string($link, $_POST['konyvid']);
    $query = sprintf("INSERT INTO kolcsonzes (tagid, konyvid, kivitel) VALUES (%s, %s, curdate())", $tagid, $konyvid);
    mysqli_query($link, $query) or die(mysqli_error($link));
    $create = true;
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="library.css">
    <title>Könytár</title>
</head>
<body>
    <?php include 'menu.html'; ?>

    <div class="container main-content">

        <h1>Kölcsönzések</h1>
        <?php if ($create): ?>
        <p>
            <span class="badge badge-success">Új kölcsönzés létrehozva main dátummal</span>
        </p>
        <?php endif; ?>
        <?php
            
            $query = "SELECT kolcsonzes.id, tagid, kivitel, konyvid, kivitel, vissza, tag.nev as tagnev, konyv.cim as cim FROM kolcsonzes INNER JOIN tag ON tag.id = tagid INNER JOIN konyv ON konyvid=konyv.id";
            $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
        ?>

            <table class="table table-striped table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tag</th>
                        <th>Könyv</th>      
                        <th style="white-space:nowrap;">Kivitel</th>      
                        <th style="white-space:nowrap;">Visszahozatal</th>
                        <th></th>
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['tagnev']?></td>
                        <td><?=$row['cim']?></td>
                        <td>
                            <?=$row['kivitel']?>
                        </td>
                        <td>
                            <?php if ($row['vissza']): ?>
                                <?=$row['vissza']?>
                            <?php else: ?>
                                <a class="btn btn-success btn-sm" href="edit-lending.php?lendingid=<?=$row['id']?>&returnCurrentDate">
                                    <i class="fa fa-calendar"></i> Vissza mai dátummal
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$row['vissza']): ?>
                            <a class="btn btn-success btn-sm" href="edit-lending.php?lendingid=<?=$row['id']?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                        <td>
                        <a class="btn btn-danger btn-sm" href="edit-lending.php?lendingid=<?=$row['id']?>&delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                        
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>

            <form method="post">
                <div class="card">
                    <div class="card-header">
                        Új kölcsönzés
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for='tagid'>Tag</label>
                            <select class="form-control" name='tagid' id='tagid'>
                            <?php
                                $queryMembers = 'SELECT id, nev FROM tag';
                                $resultQueryMembers = mysqli_query($link, $queryMembers) or die(mysqli_error($link));
                                while ($rowMember = mysqli_fetch_array($resultQueryMembers)):
                            ?>
                                <option value="<?=$rowMember['id']?>"><?=$rowMember['nev']?></option>
                            <?php endwhile; ?>
                            </select>
                        </div>

                         <div class="form-group">
                            <label for='konyvid'>Könyv</label>
                            <select class="form-control" name='konyvid' id='konyvid'>
                            <?php
                                $queryBooks = 'SELECT id, cim, isbn FROM konyv WHERE id NOT IN (SELECT konyvid FROM kolcsonzes WHERE vissza IS NULL)';
                                $resultQueryBooks = mysqli_query($link, $queryBooks) or die(mysqli_error($link));
                                while ($rowBook = mysqli_fetch_array($resultQueryBooks)):
                            ?>
                                <option value="<?=$rowBook['id']?>"><?=$rowBook['cim']?> (<?=$rowBook['isbn']?>)</option>
                            <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-success" name="create" type="submit" value="Létrehozás main dátummal" />
                    </div>
                </div>  


            </form>

            <?php
                closeDb($link);
            ?>
    </div>
</body>
</html>