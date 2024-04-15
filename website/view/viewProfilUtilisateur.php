<main>

    <section id="presentation" class="bento">
        <h2 class="title">
            <?php
            $profilName = $_SESSION["selectedProfil"];
            echo $profilName;
            ?>
        </h2>
        <article class="bentoBox boxHome">
            <p class="text"> <?php if (!empty($_SESSION["profilBio"])) {
                                    echo $_SESSION["profilBio"];
                                } ?> </p>
            <p class="text"> Genre préféré : <?php echo $_SESSION["profilGenre"]; ?> </p> 
            <p class="text"> Groupe préféré : <?php echo $_SESSION["profilGroup"]; ?> </p> 
            <p class="text"> Guitariste préféré : <?php echo $_SESSION["profilGuitarist"]; ?> </p>
            <p class="text"> Nombre de contribution(s) : <?php echo $_SESSION["nbrContribution"]; ?> </p>

    </section>
    <?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) { ?>
        <section id="contribution" class="bento">
            <h2 class="title">Contributions</h2>
            <article class="bentoBox boxHome">
                <?php if (isset($_SESSION['contributions']) && !empty($_SESSION['contributions'])) : ?>
                    <?php foreach ($_SESSION['contributions'] as $contribution) : ?> 
                    <div>
                        <p class="text"><?= $contribution['brand'] ?> - <?= $contribution['name'] ?> (<?= $contribution['dateD'] ?>)</p>
                        <form method="post" action="?action=Suppression">
                            <input type="hidden" name="idContribution" value="<?= $contribution['idContribution'] ?>">
                            <button type="submit" name="delete">Supprimer</button>
                        </form>
                    </div>
                    <hr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text">Aucune contribution.</p>
                <?php endif; ?>

            </article>
        </section>

        <div id="deleteUser" class="bento">
        <form method="post" action="?action=Ban">
            <input type="hidden" name="banUser" value="<?=$profilId?>">
            <button type="submit" name="delete">Bannir Utilisateur</button>
            </form>
        </div>
    <?php } else {
    }
    ?>
</main>