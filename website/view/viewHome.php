

<main>
        <section id="presentation" class="bento">
                <h2 class="title">Presentation</h2>
                <article class="bentoBox boxHome ">
        
                        <h3 class="title">Bienvenue sur Gears of Guitarist.</h3>
                        <p class="text">
                                Que vous soyez guitariste, passionné de guitare, passionné de musiques ou tout simplement curieux, ce site est fait pour vous ! <br> <br>
                                Vous trouverez ici toutes les informations sur vos guitaristes préférés: les albums, les musiques et le matériel qu'il utilise sur chaque musique. <br><br>
                                Vous avez des connaissances concernant le matériel d'un guitarsite ? <br><br> Alors connectez-vous et <em>Ajoutez du matériel</em> via la page d'un guitariste !
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