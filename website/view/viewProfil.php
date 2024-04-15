<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<?php if (isset($_SESSION["pseudo"])) { ?>
    <main>
        <!-- ================Profil de l'utilisateur connecté============ -->

        <section id="presentation" class="bento">
            <h2 class="title">
                <?php
                $profilName = $_SESSION["pseudo"];
                echo $profilName;
                ?>
            </h2>
            <article class="bentoBox boxHome">
                <p class="text"> <?php if (!empty($_SESSION["userBio"])) {
                                        echo $_SESSION["userBio"];
                                    } ?> </p>
                <p class="text"> Genre préféré : <?php echo $_SESSION["userGenre"]; ?> </p>
                <p class="text"> Groupe préféré : <?php echo $_SESSION["userGroup"]; ?> </p>
                <p class="text"> Guitariste préféré : <?php echo $_SESSION["userGuitarist"]; ?> </p>
                <p class="text"> Nombre de contribution(s) : <?php echo $_SESSION['nbrContributionUser']; ?> </p>
            </article>

        </section>
        <!-- ==========Formulaire ajout d'info profil et modification identifiants========== -->
        <section id="formSignup" class="bento">
            <h3 class="title">Personaliser votre profil</h3>
            <article class="bentoBox boxHome">
                <?php if (isset($_SESSION["msgAddProfil"])) {
                    $message = $_SESSION["msgAddProfil"];
                ?>
                    <p class="text"><?php echo $message ?></p>
                <?php unset($_SESSION['msgAddProfil']);
                } ?>
                <form id="addProfil" class="conForm" action="#" method="POST">
                    <input type="text" name="genre" placeholder="Genre préféré" /><br>
                    <input type="text" name="group" placeholder="Groupe préféré" /><br>
                    <input type="text" name="guitarist" placeholder="Guitariste préféré" /><br>
                    <textarea type="message" name="bio" placeholder="Quelque mot sur vous"></textarea><br>
                    <input type="submit" value="Modifier" />
                </form>
            </article>

            <h3 class="title">Modifier vos identifiants</h3>
            <article class="bentoBox boxHome">
                <?php if (isset($_SESSION["msgUpdateProfil"])) {
                    $message = $_SESSION["msgUpdateProfil"];
                ?>
                    <p class="text"><?php echo $message ?></p>
                <?php unset($_SESSION['msgUpdateProfil']);
                } ?>
                <form id="updateProfil" class="conForm" action="#" method="POST">
                    <label class="text" for="pseudo">Pseudo actuel : <?php echo $_SESSION["pseudo"]; ?></label><input type="text" name="newPseudo" placeholder="Nouveau pseudo" /><br>
                    <label class="text" for="">Mail actuel : <?php echo $_SESSION['mail']; ?></label><input type="mail" name="newMail" placeholder="Nouvelle adresse mail" /><br>
                    <input type="password" name="newPassword" placeholder="Nouveau mot de passe" /><br>
                    <input type="submit" value="Modifier" />
                </form>
            </article>

            <div id="deleteUser" class="bento">
                <form method="post" action="?action=Ban">
                    <input type="hidden" name="banUser" value="<?= $userId ?>">
                    <button type="submit" name="delete">Supprimer Compte</button>
                </form>
            </div>
        </section>

    </main>
<?php } else {
    header("Location:?action=Accueil");
} ?>