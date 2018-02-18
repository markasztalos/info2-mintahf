# PHP Webalkalmazás elkészítése

## Sitemap - az alkalmazás struktúrája
Az alkalmazást több különböző PHP fájl valósítja meg: 
* Index.php: Ez a főoldal, ahol megjelenik az oldal címe és linkek az egyes aloldalakra.
* Books.php: Ez az oldal megjeleníti a könyveket és lehetőség van új könyv létrehozására.
* Edit-book.php: Ezen a oldalon egy-egy könyvet lehet szerkeszteni
* Members.php: Ez az oldal megjeleníti az adatbázisban tárolt tagok listáját, ugyanitt lehet új tagok létrehozni.
* Edit-member.php: Ezen az oldalon egy-egy tag adatait lehet szerkeszteni.
* Lendings.php: Ez az oldal megjeleníti a jelenlegi kölcsönzéseket, ugyanitt lehet új kölcsönzést indítani.
* Edit-lending.php: Ezen az oldalon lehet egy-egy kölcsönzés adatait módosítani. 

A fentieken kívül néhány további segédfájlt is fogunk használni:
* Library.css: Közöss css fájl, amiben a stílusokat definiálhatjuk. Erre minden oldal hivatkozik majd
* menu.html: Minden oldal tetején megjelenik majd egy menü, amely linkeket tartalmaz a könyvek, tagok és kölcsönzések oldalakra. Ezt a menüt, hogy ne kelljen minden oldalon külön megírni, egy külön fájlba helyezzük, amelyet importálunk majd minden oldalra. 
* Library.php: Az adatbáziscsatlakozáshoz szükséges PHP nyelven megírt segédfüggvényeket tartalmazza.

Lesz tehát egy közös menü, amely minden oldalon megjelenik. Itt linkeket jelenítünk meg a könyvek, tagok és kölcsönzések listáira, vagyis a books.php, members.php és lendings.php oldalakra. 

Az index.php oldal megjeleníti a menüt és kiírja az oldal címét. 

## Közös menü és index.php
Kezdjük az index.php fájl implementációjával: 
```html
<html>
<head>
    <link rel="stylesheet" href="library.css">
    <title>Könytár</title>
</head>
<body>
    <div>
      <!-- menu -->
      <a href="index.php">Főoldal</a>
      <a href="books.php">Könyvek</a>
      <a href="members.php">Tagok</a>
      <a href="lendings.php">Kölcsönzések</a>

    </div>
     <div class="main-content">
        <h1>Könyvespolc</h1>
        <p>Könyvtár adatbázis, kölcsönzések adminisztrációja</p>
    </div>
</body>
</html>
```

A fenti  kódrészlet egy egyszerű HTML oldalt tartalmaz. A menüben 4 link található, egy a főoldalra mutat, három pedig az egyes aloldalakra. 
A főoldalon lévő tartalmat egy main-content css osztállyal ellátott div tartalmazza.  Ez a css osztály, a hivatkozott library.css-ben található és egy felső margót definiál:

```css
/* library.css */
.main-content {
    margin-top:1em;
}
```

A XAMPP program gyökérkönyvtárában a htdocs mappában találhatók azok a fájlok, amelyeket kiszolgál a webszerver. Hozzunk létre ezen belül az info2/library könyvtárakat. A fenti index.php és library.css fájlokat pedig helyezzük el a <XAMPP_Gyökér>/htdocs/info2/library könyvtárba. 
Ezután a böngészőben a localhost://info2/library/index.php címet beírva az alábbi oldalt kell lássuk: 

![Kép](./indexphp-nostyle.png)
 
Mivel a menüt majd minden oldalon szeretnénk megjeleníteni, érdemes azt külön fájlba kitenni. 

A menüt tartalmazó div-et tehát helyezzük át az index.php-ból a menu.html fájlba, majd hivatkozzuk ezt az eredeti index.php-ban:

index.php:
```html
<html>
<head>
    <link rel="stylesheet" href="library.css">
    <title>Könytár</title>
</head>
<body>
    <?php include 'menu.html'; ?>

     <div class="main-content">
        <h1>Könyvespolc</h1>
        <p class="lead">Könyvtár adatbázis, kölcsönzések adminisztrációja</p>
    </div>
</body>
</html>
```

menu.html:
```html
<div class="main-content">
        <h1>Könyvespolc</h1>
        <p class="lead">Könyvtár adatbázis, kölcsönzések adminisztrációja</p>
</div>
```

## Design - CSS

### Bootstrap
Ahhoz, hogy egy alkalmazás szépen nézzen ki, a HTML kód mellett megfelelően összehangolt CSS szabályokra van szükség. Egy egységes design elérése általában nagy feladat, de szerencsére vannak előre felhasználható keretrendszerek. Ezek közül az egyik legelterjedtebb a [Bootstrap](https://getbootstrap.com/).
Alapvető funkcionalitása az, hogy biztosít egy css könyvtárat, amelyet importálnunk kell az oldalunkon, ezután pedig a különböző elemeken alkalmazhatjuk az előre definiált css osztályokat. Így egy egységes megjelenítést érhetünk el anélkül, hogy ezzel a továbbiakban küön kelljen foglalkoznunk. Az [elérhető osztályokat és működésüket részletesen dokumentálták](https://getbootstrap.com/docs/4.0/getting-started/introduction/). 
Amikor egy css fájlt szeretnénk használni (mint például a library.css-t), azt el kell tárolni a könyvtárunkban, majd hivatkozni kell a HTML fájlokban. Az olyan általános fájlokat, mint amilyen például a bootstrap keretrendszer biztosít gyakran frissítik, ezért ilyenkor biztosítani kell, hogy mindig a legfrissebb verzió legyen meg nálunk is. Egy alternatív megoldás, hogy ahelyett, hogy letöltenénk ezt a fájlt, valamilyen központi oldalról hivatkozzuk. A bootstrap aktuális verziója például elérhető a következő linken: 

```
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css
```
Amennyiben ezt hivatkozzuk, akkor nincs szükség a fájl letöltésére. 
Alakítsuk át az index.php-t a következő módon:
```html
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="library.css">
    <title>Könytár</title>
</head>
<body>
    <?php include 'menu.html'; ?>

    <div class="container main-content">
      <div class="jumbotron">
        <h1>Könyvespolc</h1>
        <p class="lead">Könyvtár adatbázis, kölcsönzések adminisztrációja</p>
      </div>
    </div>
</body>
</html>
```

A menu.html tartalma pedig legyen a következő: 
```html
<div class="container">
  <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
    <a class="navbar-brand" href="index.php">Főoldal</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a href="books.php" class="nav-link">Könyvek</a>
      </li>
      <li class="nav-item">
        <a href="members.php" class="nav-link">Tagok</a>
      </li>
      <li class="nav-item">
        <a href="lendings.php" class="nav-link">Kölcsönzések</a>
      </li>
    </ul>
  </nav>
</div>
```

A fenti változtatások eredményeképpen az oldal a következőképpen néz ki: 
![Kép](./indexphp-bootstrap.png)
 
Kezdjük az index.php változásaival:
* Az oldal fejlécében (head tag) hivatkozzuk a bootstrap css fájlát. 
* A címet és a leírást tartalmazó kódrészletet egy container css osztállyal ellátott div-be, azon belül pedig egy jumbotron css osztállyal ellátott divbe helyezzük.
    * A container div-eket arra használjuk, hogy az oldal tartalma fix szélességű legyen és középre legyen igazítva. Minden további tartalmaz ilyen container elemebe helyezünk. Így ha a böngészőt átméretezzük a tartalom szélessége akkor sem változik. Részletesebben lásd a [dokumentációban](https://getbootstrap.com/docs/4.0/layout/overview/#containers)
    * A [jubotron](https://getbootstrap.com/docs/4.0/components/jumbotron/) egy nagy szürke keretes címsort jelenít meg

A menu.html továbbra is csak a három linket tartalmazza, de a bootstrap által biztosított menüsorban ([navbar](https://getbootstrap.com/docs/4.0/components/navbar/)) jeleníti meg ezeket. 

Összefoglalva elmondható, hogy néhány egyszerű szabály segítségével sokkal szebbé tehetjük az alkalmazás kinézetét. Ehhez általában elegendő néhány css osztályt alkalmazni. Azonban ezek a beállítások az oldal tartalmát és működését nem befolyásolják. 

### Fontawesome

Egy webalkalmazás mindig jobban néz ki, ha sok képet és ikont tartalmaz. Egy ingyenesen elérhető ikon könyvtára a [`fontawesome`](https://fontawesome.com/), amely a bootstraphez hasonlóan nagyon egyszerűen használható. 

Működéséhez mindössze egy újabb css fájlra lesz szükség:
```html
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
```
 Ezután a használata igen egyszerű:
  * Egy új ikon megjelenítéséhez a következő tag-et kell elhelyezni: `<i class="fa fa-search"></i>`, ahol a `fa` osztály a fontawesome könyvtárra utal, a konkrét ikont pedig a `fa-search` osztály azonosítja. Ebben az esetben egy nagyító jelenik meg. Ha más ikont szeretnénk megjeleníteni, akkor csak a *search* szöveget kell kicserélni. A használható ikonok listája a [könyvtár oldalán](https://fontawesome.com/icons?d=gallery) elérhető.


## Adatbázis kezelés PHP-ban
Az oldalon szükség lesz arra, hogy csatlakozzunk az adatbázishoz és lekérdezzük annak tartalmát, vagy más SQL szkriptet hajtsunk végre rajta. Ehhez PHP nyelven a [`mysqli`](http://php.net/manual/en/book.mysqli.php) osztálykönyvtárat fogjuk használni. A könyvtár függvényei mind a `mysqli_` prefixszel kezdődnek. 
 * Először csatlakozni kell az adatbázishoz, ehhez a `mysqli_connect` függvényre lesz szükség, amelynek paraméterként át kell adni az adatbázisszerver címét és a belépéshez használt felhasználónevet és jelszót. A függvény visszatérési értéke az adatbázis kapcsolatot leíró azonosító. Minden további függvénynek ezt az azonosítót kell átadni. 
 * Kapcsolódás után a `mysqli_select` függvénnyel ki kell választani az adatbázis szerveren belüli adatbázist, amelyen a lekérdezésket futtatni fogjuk. Jelen esetben ez a `konyvtar` adatbázis lesz. 
 * Bármilyen SQL szkriptet a `mysqli_query` függvénnyel tudunk lefuttatni. 
 * Az adatbáziskezelés befejeztével érdemes lezárni a kapcsolatot, hogy felszabadítsuk az erőforrásokat, erre a `mysqli_close` függvény való. 



### Hibakezelés
Gyakran előfordul, hogy az adatbáziskezelés küzben valamilyen hiba történik. Ezt általában a megfelelő függvény visszatérési értéke jelzi. Amennyiben a visszatérési érték alapján tudjuk, hogy hiba történt, akkor a `mysqli_error` függvénnyel tudjuk a hiba részleteit lekérdezni. 

Egy egyszerű hibakezelési módszer a következő: tegyük fel, hogy a `mysqli_query($db, $query)` hívást szereténk lefuttatni. Ehelyett írhatjuk a következő kódot:
```php
$result = mysqli_query($db, $query) or die(mysqli_error($db));
```
A fenti kódrészletekben a `$db` változó az adatbáziskapcsolat azonosítója, amivel a `mysqli_connect` visszatér, `$query` pedig egy string, ami a végrehajtandó utasítást tartalmazza. A `$result` változó tartlmazza a lekérdezés visszatérési eredményét. Amennyiben azonban hiba történik, akkor nem lesz a `mysqli_query` függvénynek visszatérési értéke, pontosabban `null` lesz. Ilyenkor, mivel `or` operátor lusta kiértékelésű, a jobb oldali operandus, vagyis a `die(mysqli_error($db))` kifejezés is kiértékelődik. Ha az `or` bal oldalán álló kifejezés nem üres értékkel tér vissza, akkor a jobb oldal nem kerül kiértékelésre, vagyis a `die` függvény nem fut le. A `die` függvény megállítja a `php` szkript további részeinek végrehajtását és a generálandó HTML tartalom helyett a paraméterként megkapott szöveget adja vissza. Összefoglalva tehát, amennyiben a lekérdezés rendben végrehajtódott, akkor a program futása folytatódik, amennyiben viszont hiba történt, akkor egy HTML tartalom helyett a hiba szövegét leíró szöveget kapunk vissza a szervertől. 

### Lekérdezések

A `mysqli_query` segítéségével bármilyen `SQL` utasítást elküldhetünk. Egy `SQL` utasításnak többféle visszatérési értéke is lehet:
 * Történhet hiba a végrehajtásnál, ennek a kezelését a fentiekben már láttuk. 
 * Van olyan utasítás, amely esetén a visszatérési érték egy skalár érték, amely a módosított sorok számát tartalmazza. Ilyen utasítás például az `INSERT`, vagy a `DELETE`.
 * Lekérdezés (`SELECT`) esetén viszont a visszatérési érték egy reláció lesz, vagyis egy tábla, amelynek több sora és oszlopa lehet. 

Nézzük, hogy egy lekérdezés eredményét hogyan lehet PHP-ban feldolgozni:
```php
$result = mysqli_query($db, "SELECT id, cim FROM konyv") or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    //aktuális sor id-ja: $row['id']
    //aktuális sor címe: $row['cim']
}
```
A fenti kódban a `mysqli_query` visszatérési értéke egy olyan objektum, amely segít feldolgozni lekérdezés eredményét mégpedig úgy, hogy sorról sorra lépkedunk egy kurzor segítségével. A kurzur tehát mindig egy adott sorra mutat és lekérdezhető az adott sorban az egyes cellák értéke. Amikor egy sor feldolgozását befejeztük, továbblépünk a következő sorra. 

A `$result` objektumon ciklusban meg kell hívni tehát `mysqli_fetch_array` függvényt, amely mindig az aktuális sorra mutató kurzorral tér vissza. Amikor nincs már több sor, a visszatérési érték is `null` lesz. 

### Védekezés SQL injection ellen

Tegyük fel, hogy írunk egy oldalt, ahol a felhasználó megad egy szöveget és az ilyen című könyv adatait megjelenítjük. Tegyük fel , hogy a felhasználó által beírt szöveget a `$cim` változóba mentjük el. Ekkor a következő lekérdezést kellene megírnunk: `SELECT * FROM konyv WHERE cim = <cim>`, ahol a `<cim>` helyére behelyettesítjük a változó értékét. Ezt például a következő `php` szktripttel tehetjük meg: 

```php
$query = sprintf("SELECT * from konyv WHERE cim = '%s'", $cim);
```
Az `sprintf` függvény a `%s` helyére beilleszti a $cim értékét. Tegyük fel, hogy a `$cim` tartalma pontosan az a szöveg, amit a felhasználó beírt az egyik szövegmezőbe. Amennyiben $id értéke `A gyűrűk ura`, akkor ay ilyen című könyv kerül lekérdezésre. 

Tegyük fel most, hogy a felhasználó a következő szöveget adja meg címként:
```
A gyűrűk ura '; DELETE FROM konyv WHERE id > 0; #
```

Amennyiben összefűzzük a két sztringet, a következő utasítást kapjuk: 
```
SELECT * from konyv WHERE cim = 'A gyűrűk ura '; DELETE FROM konyv WHERE id > 0; #'
```
A `#` jel a megjegyzés kezdete. Könnyen látható, hogy a fenti utasítást lefuttatva törölni fogjuk az adatbázisban a könyv tábla tartalmát. Ezt a fajta sebezhetőséget SQL injectionnek nevezzük és mindenképpen fel kell készíteni az adatbázisunkat az ilyen támadás elleni védekezésre. 

A megoldás az, hogy nem engedünk bármilyen stringet előzetes ellenőrzés nélkül beilleszteni egy utasításba, amelyet elküldünk az adatbázisszervernek. Előtte ugyanis a felhasználótól jövő szöveget ún. *escape*-elni kell. Ez azt jelenti, hogy azokat a karaktereket, amelyek lezárhatják az idézőjeleket speciális *escape szekvenciákkal* kell helyettesíteni. Szerencsére ezt a feladatot elvégzi helyettünk a `mysqli_real_escape_string` függvény. Tehát nincs más dolgunk, mint mielőtt egy string-et felhasználunk, előtte használnunk kell a függvényt. 

```php
$query = sprintf("SELECT * from konyv WHERE cim = '%s'", 
    mysqli_real_escape_string($db, $cim));
```

Ezzel a kóddal például a támadó által megadott támadó jellegű cím ellen tudunk védekezni, így a következő, immár biztonságos, parancsot kapjuk: 
```sql
SELECT * from konyv WHERE cim = 'A gyűrűk ura \'; DELETE FROM konyv WHERE id > 0; #'
```

### Library.php

Az adatbáziskezelés megkönnyítésére néhány segédfüggvényt definiálunk, amelyeket egy külön fájlba, a library.php-ba teszünk:

```html
<?php
function getDb() {
    $link = mysqli_connect("localhost", "root", "") 
           or die("Kapcsolódási hiba: " . mysqli_error());
    mysqli_select_db($link, "konyvtar");
    mysqli_query ($link, "set character_set_results='utf8'");
    mysqli_query ($link, "set character_set_client='utf8'");
    return $link;   
}

function closeDb($link) {
    mysqli_close($link);
}
?>
```

A `getDB` segédfüggvény csatlakozuk az adatbázishoz, megadja, hogy a `konyvtar` adatbázist szeretnénk használni, majd lefuttat két `SQL` utasítást, amelyek biztosítják, hogy UTF-8 kódolást használjunk az adatcsere során, vagyis a magyar ékezetets karakterek is jól működjenek. A függvény visszatérési értéke (`$link`) az adatbáziskapcsolat azonosítója. 

A másik segédfüggvény lezárja a paraméterként megkapott adatbázis kapcsolatot. 

## Books.php

A könyv tábla tartalmát a `books.php` oldalon jelenítjük meg: 

```html
<?php
include 'library.php';
$link = getDb(); 
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
        <h1>Könyvek</h1
        <?php
            $querySelect = "SELECT id, isbn, cim, szerzo, kiado, megjelenesev FROM konyv";
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

            <?php
                closeDb($link);
            ?>
    </div>
</body>
</html>
```

Nézzük végig az oldal működését részletesen: 
 * Az oldal elején importáljuk a `library.php` tartalmát és inicializáljuk az adatbázis kapcsolatot. 
 * A `head` tagban importáljuk a saját css fájlunkat (`library.css`) és a hivatkozott bootstrap, fontawesome könyvtárakat. 
 * Az oldal tetejére beillesztjük a `menu.html` tartalmát.
 * Megírjuk a megfelelő lekérdezést, majd végigiterálva a sorain, kilistázzuk a könyveket egy táblázatban.
    * A táblázat egy egyszetű HTML táblázat. A fejlécét `thead`, a törzsének a sorait `tbody` elemek közé írjuk. 
    * A táblázat formázására a [bootstrap különböző css osztályait](https://getbootstrap.com/docs/4.0/content/tables/) használjuk:
        * `table`: ezzel jelezzük, hogy bootstrap tábla formázását használjuk 
        * `table-striped`: a páros és páratlan sorok háttere legyen különböző ("csíkos")
        * `table-sm`: kisméretű táblázat (kisebb betűtítpus használata)
        * `table-bordered`: a táblázat szegélyei legyenek láthatók





