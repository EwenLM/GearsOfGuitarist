<?php

?>

<main>

    <section class="bento">
        <h3 class="title">Liste des guitaristes</h3>
        <article class="bentoBox boxHome">
            <ul>
            <?php foreach ($selectGuitarist as $guitarist) : ?>
                <li>
                    <form method="post" action="?action=ProfilGuitariste">
                        <input type="hidden" class="buttonGuitarist" name="guitarist" value="<?= $guitarist['name'] ?>">
                        <button type="submit" class="btn-link"><?= $guitarist['name'] ?></button>
                    </form>
                </li>
            <?php endforeach; ?>
            </ul>
        </article>
    </section>



</main>