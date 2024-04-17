<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGuitarist.php';
require RACINE . '/model/functionGear.php';



//==================Générer la page selon le guitariste=========================

if (isset($_POST['guitarist'])) {
    // Stocker le nom du guitariste sélectionné dans une variable locale
    $guitaristName = $_POST['guitarist'];

    $result = selectGuitarist();
    $isExist = array_column($result, 'name');

    // Obtenir les informations du guitariste à partir de son nom
    if (in_array($guitaristName, $isExist)) {
        $guitarist = getGuitarist($guitaristName);

        // Enregistrement dans la session des informations du guitariste
        $_SESSION['guitarist']['name'] = $guitaristName;
        $_SESSION['guitarist']['bio'] = $guitarist['bio'];
        $_SESSION['guitarist']['group'] = $guitarist['groupG'];
        $_SESSION['guitarist']['id'] = $guitarist['idGuitarist'];

        $guitarsData = [];
    }
}
$idGuitarist = $_SESSION['guitarist']['id']; ?>

<script>
    //Enregistrement de l'id dans une constante JavaScript pour l'utiliser dans le script.js 
    const artistId = '<?php echo $idGuitarist; ?>';
</script>


<?php
// =============Selection des musiques en fonction du guitariste============
$music = getMusic($idGuitarist);
$albums = [];
foreach ($music as $track) {
    $albumTitle = $track['title'];
    $trackName = $track['name'];
    $trackId = $track['idMusic'];
    if (!isset($albums[$albumTitle])) {
        $albums[$albumTitle] = [];
    }
    $albums[$albumTitle][] = $trackName;

    //============= Récupérer les guitares lié aux musiques===========
    $guitarGear = selectMusicGuitar($trackId);

    if (!empty($guitarGear)) {
        $guitarsName = [];
        $guitarsBrand = [];
        $guitarsYear = [];
        $guitarIdMusics = [];

        // Parcourir les équipements de guitare pour récupérer les détails
        foreach ($guitarGear as $guitar) {
            $guitarsName[] = $guitar['name'];
            $guitarsBrand[] = $guitar['brand'];
            $guitarsYear[] = $guitar['yearY'];
            $guitarIdMusics[] = $guitar['idMusic'];
        }

        // Stocker les informations des équipements de guitare dans une variable locale
        $guitarsData[$trackName] = [
            'names' => $guitarsName,
            'brands' => $guitarsBrand,
            'years' => $guitarsYear,
            'idMusics' => $guitarIdMusics
        ];
    }

    //===============Récupérer Ampli en fonction liée aux  musiques===================
    $ampGear = selectMusicAmp($trackId);

    if (!empty($ampGear)) {
        $ampName = [];
        $ampBrand = [];
        $ampYear = [];
        $ampIdMusics = [];

        // Parcourir les équipements de guitare pour récupérer les détails
        foreach ($ampGear as $amp) {
            $ampName[] = $amp['name'];
            $ampBrand[] = $amp['brand'];
            $ampPower[] = $amp['powerP'];
            $ampTechnology[] = $amp['technology'];
            $ampIdMusics[] = $amp['idMusic'];
        }

        // Stocker les informations des équipements de guitare dans une variable locale
        $ampsData[$trackName] = [
            'names' => $ampName,
            'brands' => $ampBrand,
            'powers' => $ampPower,
            'technologies' => $ampTechnology,
            'idMusics' => $ampIdMusics
        ];
    }


    //===============Récupérer Pédales en fonction liée aux  musiques===================
    $pedalGear = selectMusicPedal($trackId);

    if (!empty($pedalGear)) {
        $pedalName = [];
        $pedalBrand = [];
        $pedalEffect = [];
        $pedalIdMusics = [];

        // Parcourir les équipements de guitare pour récupérer les détails
        foreach ($pedalGear as $pedal) {
            $pedalName[] = $pedal['name'];
            $pedalBrand[] = $pedal['brand'];
            $pedalEffect[] = $pedal['effect'];

            $pedalIdMusics[] = $pedal['idMusic'];
        }

        // Stocker les informations des équipements de guitare dans une variable locale
        $pedalsData[$trackName] = [
            'names' => $pedalName,
            'brands' => $pedalBrand,
            'effects' => $pedalEffect,
        ];
    }
}



// ==================Ajouter du matériel associé à une musique=====================
// Récupérer les musiques liées au guitariste pour affichage menu déroulant

$selectMusic = getMusic($idGuitarist);
$isMusic = array_column($selectMusic, 'name');

$musicByAlbum = array();
foreach ($selectMusic as $music) {
    $album = $music['title'];
    $musicName = $music['name'];
    if (!isset($musicByAlbum[$album])) {
        $musicByAlbum[$album] = array();
    }
    $musicByAlbum[$album][] = $musicName;
}
//========Ajouter Guitare==============

if (isset($_POST["nameG"]) && isset($_POST["brandG"]) && isset($_POST["yearG"]) && isset($_POST["selectedMusic"])) {
    $nameG = $_POST["nameG"];
    $brandG = $_POST["brandG"];
    $yearG = $_POST["yearG"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameG) || empty($brandG) || empty($yearG) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[a-zA-Z\d\s]+$/", $nameG) || !preg_match("/^[a-zA-Z\d\s]+$/", $brandG)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } elseif (!preg_match("/^\d{4}$/", $yearG)) {
        $msg = 'Entrez une année au format yyyy';
    } else {

        $addGear = addGear($nameG, $brandG);
        $addGuitar = addGuitar($yearG);
        $addContribution = addContribution();
        if ($addGear === true && $addGuitar === true && $addContribution === true) {
            $msg = 'Guitare ajoutée ! ';
        } else {
            $msg = $addGuitar;
        }
    }

    $_SESSION["msgGuitar"] = $msg;
}

//===========Ajouter Ampli============

if (isset($_POST["nameA"]) && isset($_POST["brandA"]) && isset($_POST["power"]) && isset($_POST["techno"])) {
    $nameG = $_POST["nameA"];
    $brandG = $_POST["brandA"];
    $power = $_POST["power"];
    $techno = $_POST["techno"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameG) || empty($brandG) || empty($power) || empty($techno) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[a-zA-Z\d\s]+$/", $nameG) || !preg_match("/^[a-zA-Z\d\s]+$/", $brandG) || !preg_match("/^[a-zA-Z\d\s]+$/", $power) || !preg_match("/^[a-zA-Z\d\s]+$/", $techno)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } else {

        $addGear = addGear($nameG, $brandG);
        $addAmp = addAmp($power, $techno);
        $addContribution = addContribution();
        if ($addGear === true && $addAmp === true && $addContribution === true) {
            $msg = 'Ampli ajouté ! ';
        } else {
            $msg = $addAmp;
        }
    }
    $_SESSION['msgAmp'] = $msg;
}


//=========Ajout Pédale==========

if (isset($_POST["nameP"]) && isset($_POST["brandP"]) && isset($_POST["effect"])) {
    $nameP = $_POST["nameP"];
    $brandP = $_POST["brandP"];
    $effect = $_POST["effect"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameP) || empty($brandP) || empty($effect) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $nameP) || !preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $brandP) || !preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $effect)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } else {

        $addGear = addGear($nameP, $brandP);
        $addPedal = addPedal($effect);
        $addContribution = addContribution();
        if ($addGear === true && $addPedal === true && $addContribution === true) {
            $msg = "Pédale d'effet ajoutée";
        } else {
            $msg = $addPedal;
        }
    }
    $_SESSION['msgPedal'] = $msg;
}

// ==================Afficher Matériel utilisé=================

function getGearMusic()
{
    $idGuitarist = $_SESSION['id'];
    $selectMusic = getMusic($idGuitarist);

    $musicByAlbum = array();
    foreach ($selectMusic as $music) {
        $album = $music['title'];
        $musicName = $music['name'];
        if (!isset($musicByAlbum[$album])) {
            $musicByAlbum[$album] = array();
        }
        $musicByAlbum[$album][] = $musicName;
    }

    // Initialiser un tableau pour stocker les IDs de musique
    $musicIds = array();

    // Parcourir toutes les pistes dans $selectMusic
    foreach ($selectMusic as $music) {
        $musicName = $music['name'];
        // Obtenir l'ID de la musique en utilisant la fonction musicIdByName
        $idMusic = musicIdByName($musicName);

        // Vérifier si l'ID de la musique est valide (non nul)
        if ($idMusic !== null) {
            // Ajouter l'ID de la musique au tableau des IDs de musique
            $musicIds[] = $idMusic;
        }
    }

    // Parcourir tous les IDs de musique
    foreach ($musicIds as $idMusic) {
        // Sélectionner les détails de la guitare pour chaque musique
        $guitarGear = selectMusicGuitar($idMusic);

        // Assurez-vous que $guitarGear n'est pas vide avant de le traiter
        if (empty($guitarGear)) {
            $msg = 'Aucune guitare ajoutée';
            $_SESSION['noguitare'] = $msg;
        } else {
            $nameGuitar = $guitarGear['name'];
            $_SESSION['nameGuitar'] = $nameGuitar;

            $brandGuitar = $guitarGear['brand'];
            $_SESSION['brandGuitar'] = $brandGuitar;

            $year = $guitarGear['yearY'];
            $_SESSION['year'] = $year;
        }
    }
}


if (isset($_SESSION['guitarist']['name'])) {

    include RACINE . '/view/head1.php'; ?>
    <script src="./asset/scripts/script.js" defer></script>
    <script src='./asset/scripts/guitarist.js' defer></script>
    <!-- si l'utilisateur est connecté chargement du script qui gere l'affichage d'ajout de matériel -->
    <?php if (isset($_SESSION['pseudo'])) { ?>
        <script src='./asset/scripts/gear.js' defer></script>
    <?php } ?>

<?php include RACINE . '/view/head2.php';
    include RACINE . '/view/header.php';

    include RACINE . '/view/viewProfilGuitarist.php';

    include RACINE . '/view/footer.php';
} else {
    header("Location:?action=Accueil");
}

?>