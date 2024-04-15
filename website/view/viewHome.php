

<main>
        <section id="presentation" class="bento">
                <h2 class="title">Presentation</h2>
                <article class="bentoBox boxHome">
                        <p class="text">Esse ad sunt tempor eiusmod ad nostrud exercitation commodo.
                                Adipisicing et dolor nostrud consequat nostrud duis laboris magna tempor aute aliqua deserunt veniam.
                                Labore est fugiat aliquip commodo dolor officia incididunt non est voluptate Lorem id.
                                Ea occaecat excepteur sint adipisicing dolore culpa adipisicing incididunt excepteur sit Lorem. <br>
                                Aliqua labore irure fugiat adipisicing. In aliqua dolore veniam et commodo commodo culpa non in occaecat nulla cupidatat
                                sit reprehenderit. Veniam excepteur Lorem minim sint deserunt ex velit velit consequat in culpa veniam.
                        </p>
                </article>
        </section>
        
        <section id="topGuitarist" class="bento">
                <h2 class="title">Derniers Guitaristes Ajoutés</h2>
                <article id="lastAdded" class="bentoBox boxHome">
                        <ul class="listLastGuitarist">
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