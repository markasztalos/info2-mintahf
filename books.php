<?php
include 'library.php';
$link = getDb(); 

$created = false;
if (isset($_POST['create'])) {
    $cim = mysqli_real_escape_string($link, $_POST['cim']);
    $szerzo = mysqli_real_escape_string($link, $_POST['szerzo']);
    $kiado = mysqli_real_escape_string($link, $_POST['kiado']);
    $isbn = mysqli_real_escape_string($link, $_POST['isbn']);
    $megjelenesev = mysqli_real_escape_string($link, $_POST['megjelenesev']);

    $createQuery = sprintf("INSERT INTO konyv(cim, szerzo, kiado, isbn, megjelenesev) VALUES ('%s', '%s', '%s', '%s', %s)",
        $cim,
        $szerzo,
        $kiado,
        $isbn,
        $megjelenesev
    );
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
    $created = true;
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

        <h1>Könyvek</h1>
        <?php if ($created): ?>
        <p>
            <span class="badge badge-success">Új könyv létrehozva</span>
        </p>
        <?php endif; ?>

        <?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>

        <form class="form-inline" method="post">
            <div class="card">
                <div class="card-body">
                    Keresés: 
                    <input style="width:600px;margin-left:1em;" class="form-control" type="search" name="search" value="<?=$search?>">
                    <button class="btn btn-success" style="margin-left:1em;" type="submit" >Search</button>
                </div>
            </div>
        </form>


        <?php
            $querySelect = "SELECT id, isbn, cim, szerzo, kiado, megjelenesev FROM konyv";
            if ($search) {
                $querySelect = $querySelect . sprintf(" WHERE LOWER(cim) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
            }
            $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
        ?>
            <table class="table table-striped table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Cím</th>
                        <th>Szerző</th>      
                        <th>Kiadó</th>      
                        <th style="white-space:nowrap;">Megjelenés éve</th>
                        <th>ISBN</th>
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['cim']?></td>
                        <td><?=$row['szerzo']?></td>
                        <td><?=$row['kiado']?></td>
                        <td><?=$row['megjelenesev']?></td>
                        <td><?=$row['isbn']?></td>
                        <td>
                            <a class="btn btn-success btn-sm" href="edit-book.php?bookid=<?=$row['id']?>">
                                <i class="fa fa-edit"></i> Szerkesztés
                            </a>
                        </td>
                        
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>
            
            <form method="post" action="">
                <div class="card">
                    <div class="card-header">
                        Új könyv hozzáadása
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input class="form-control" name="isbn" id="isbn" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="cim">Cím</label>
                            <input required class="form-control" name="cim" id="cim" type="text"  />
                        </div>
                        <div class="form-group">
                            <label for="szerzo">Szerző</label>
                            <input class="form-control" name="szerzo" id="szerzo" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="kiado">Kiadó</label>
                            <input class="form-control" name="kiado" id="kiado" type="text"  />
                        </div>
                        <div class="form-group">
                            <label for="megjelenesev">Megjelenés éve</label>
                            <input class="form-control" name="megjelenesev" id="megjelenesev" type="number" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-success" name="create" type="submit" value="Létrehozás" />
                    </div>
                </div>

            </form>

            <?php
                closeDb($link);
            ?>
    </div>
</body>
</html>