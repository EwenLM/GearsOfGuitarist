<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<main>

    <?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) { ?>

        <section id="allPseudo" class="bento">
            <h3 class="title">Utilisateurs enregistrés</h3>
            <div class="pseudo-columns">
                <?php $columnCount = 3; ?>
                <?php $usersPerColumn = ceil(count($selectUsers) / $columnCount); ?>
                <?php for ($i = 0; $i < $columnCount; $i++) : ?>
                    <div class="pseudo-column">
                        <?php for ($j = $i * $usersPerColumn; $j < min(($i + 1) * $usersPerColumn, count($selectUsers)); $j++) : ?>
                            <li>
                                <form method="post" action="?action=ProfilUtilisateur">
                                    <input type="hidden" name="pseudoProfil" value="<?= $selectUsers[$j]['pseudo'] ?>">
                                    <button type="submit" class="btn-link"><?= $selectUsers[$j]['pseudo'] ?></button>
                                </form>
                            </li>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- ==========Formulaire ajout guitariste========== -->
        <section id="formGuitarist" class="bento">
            <h2 class="title">Ajout de guitariste</h2>
            <article class="bentoBox boxHome">
                <?php if (isset($_SESSION["msgGuitarist"])) {
                    $message = $_SESSION["msgGuitarist"];
                ?>
                    <p class="text"><?php echo $message ?></p>
                <?php unset($_SESSION['msgGuitarist']);
                } ?>
                <form id="addGuitarist" class="conForm" action="" method="POST">
                    <input class="inputForm" type="text" name="id" placeholder="id Spotify" /><br>
                    <input class="inputForm" type="text" name="name" placeholder="Nom" /><br>
                    <input class="inputForm" type="text" name="group" placeholder="Groupe actuel (facultatif)" /><br>
                    <textarea class="inputForm" type="message" name="bio" placeholder="Biographie"></textarea><br>

                    <input class="btn" type="submit" value="Ajouter" />
                </form>
            </article>
        </section>

        <!-- ==========Formulaire ajout d'album========== -->
        <section id="formAlbum" class="bento">
            <h2 class="title">Ajout d'album</h2>
            <article class="bentoBox boxHome">
                <?php if (isset($_SESSION["msgAlbum"])) {
                    $message = $_SESSION["msgAlbum"];
                ?>
                    <p class="text"><?php echo $message ?></p>
                <?php unset($_SESSION['msgAlbum']);
                } ?>
                <form id="addAlbum" class="conForm" action="#" method="POST">
                    <input class="inputForm" type="text" name="title" placeholder="Titre de l'album" /><br>
                    <input class="inputForm" type="text" name="year" placeholder="Année de sortie" /><br>
                    <input class="btn" type="submit" value="Ajouter" />
                </form>
            </article>
        </section>

        <!--============Formulaire ajout de musique  -->
        <section id="formMusic" class="bento">
            <h2 class="title">Ajout de musique</h2>
            <?php if (isset($_SESSION["msgMusic"])) {
                $message = $_SESSION["msgMusic"];
            ?>
                <p class="text"><?php echo $message ?></p>
            <?php unset($_SESSION['msgMusic']);
            } ?>
            <article class="bentoBox boxHome">
                <form id="addMusic" class="conForm" action="#" method="POST">

                    <select name="guitarist" id="guitarist" class='selectForm'>
                        <option class="inputForm" value="">Sélectionnez un guitariste</option>
                        <?php
                        // Afficher le nom des guitaristes dans un menu déroulant
                        foreach ($_SESSION['selectGuitarist'] as $name) {
                            echo "<option  value='" . $name . "'>" . $name . "</option>";
                        } ?>
                    </select>

                    <select name="album" id="album" class='selectForm'>
                        <option class="inputForm" value="">Sélectionnez un album</option>
                        <?php
                        // Afficher le titre des albums dans un menu déroulant
                        foreach ($_SESSION['selectAlbum'] as $title) {
                            echo "<option value='" . $title . "'>" . $title . "</option>";
                        } ?>
                    </select>

                    <input class="inputForm" type="text" name="titleM" placeholder="Titre de la musique" /><br>
                    <input class="btn" type="submit" value="Ajouter" />

                </form>
            </article>
        </section>

    <?php } else {
        header("Location:?action=Accueil");
    }
    ?>
</main>