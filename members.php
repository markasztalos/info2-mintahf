<?php
include 'library.php';
$link = getDb(); 

$created = false;
if (isset($_POST['create'])) {
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $telefon = mysqli_real_escape_string($link, $_POST['telefon']);

    if (!$nev) {
        die("A név nem lehet üres");
    }

    $createQuery = sprintf("INSERT INTO tag(nev, email, telefon) VALUES ('%s', '%s', '%s')",
        $nev,
        $email,
        $telefon
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

        <h1>Tagok</h1>
        <?php if ($created): ?>
        <p>
            <span class="badge badge-success">Új tag létrehozva</span>
        </p>
        <?php endif; ?>
        <?php
            $eredmeny = mysqli_query($link, "SELECT id, nev, email, telefon FROM tag ORDER BY nev");
        ?>
            <table class="table table-striped table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Név</th>
                        <th>Email</th>      
                        <th>Telefon</th>      
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['nev']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['telefon']?></td>
                        <td>
                            <a class="btn btn-success btn-sm" href="edit-member.php?memberid=<?=$row['id']?>">
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
                        Új tag létrehozása
                    </div>
                    <div class="card-body">
                            <div class="form-group">
                                <label for="nev">Név</label>
                                <input required class="form-control" name="nev" id="nev" type="text" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input  class="form-control" name="email" id="email" type="text"  />
                            </div>
                            <div class="form-group">
                                <label for="telefon">Telefon</label>
                                <input class="form-control" name="telefon" id="telefon" type="text"  />
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