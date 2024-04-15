
<main>

    <section id="info" class="bentoGuitarist">
        
            <div class="imgSpotify"></div>
        <article class=" bioArtist ">    
            <h2 class="title"><?php echo  $_SESSION['guitarist']['name']; ?></h2>
            <h3 class="title"><?php echo $_SESSION['guitarist']['group']; ?></h2>

        
                <p class="bio text bentoBoxGuitarist"> <?php echo $_SESSION['guitarist']['bio']; ?> </p>
        </article>

    </section>

    <!-- Affichage des titres les plus écoutés via api spotify-->
    <section id="topFiveContainer" class="bentoGuitarist">
        <h3 class="title">Titres les plus écoutés</h3>
        <article id="topFive" class="bentoBoxGuitarist">
          <!-- Récupéré via l'api -->
        </article>
    </section>

    <!-- Affichage discographie enregistrer en bdd -->
    <section class="bentoGuitarist">
        <h3 class="title">Discographie par album</h3>
        <article id="discography" class="bentoBoxGuitarist">
            <?php if (isset($_SESSION['guitarist']['id'])) : ?>
                <?php $idGuitarist = $_SESSION['guitarist']['id']; ?>
                <?php $music = getMusic($idGuitarist);
                
                if(!empty($albums)){?>
                
                <?php foreach ($albums as $albumTitle => $tracks) : ?>
                    <a class='album-link' data-album='<?php echo $albumTitle; ?>'>
                        <h4 class='title album-title'><?php echo $albumTitle; ?></h4>
                    </a>
                
                    <div id='modal-<?php echo $albumTitle; ?>' class='modal'>
                        <div class='modal-content bentoGuitarist'>
                            <span class='close'>&times;</span>
                            <h3 class='title a'><?php echo $albumTitle; ?></h3>
                            <ul class='bentoBoxGuitarist trackList'>
                                <?php foreach ($tracks as $trackName) : ?>
                                    <li class='track-item'>
                                        <h4 class='track-title text'><?php echo $trackName; ?></h4>
                                        <div class='track-gear'>
                                            <div class="guitareInfo">
                                                <p class="text">Guitare(s) :</p>
                                                <?php
                                                // Vérifier si des guitares sont disponibles pour cette musique
                                                if (isset($guitarsData[$trackName])) :
                                                    $guitars = $guitarsData[$trackName];
                                                    foreach ($guitars['names'] as $index => $name) :
                                                ?>
                                                        <div class="guitarInfo" class="text">
                                                            <p class="text">
                                                                <?= $name ?> /
                                                                <?= $guitars['brands'][$index] ?> /
                                                                <?= $guitars['years'][$index] ?>
                                                            </p>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                else :
                                                    echo '<p class="text"> Aucune Guitare ajoutée </p>';
                                                endif;
                                                ?>
                                            </div>
                                            <hr class="hrGear">
                                            <div id="ampInfo">
                                                <p class="text">Ampli(s) :</p>
                                                <?php
                                                // Vérifier si des guitares sont disponibles pour cette musique
                                                if (isset($ampsData[$trackName])) :
                                                    $amps = $ampsData[$trackName];
                                                    foreach ($amps['names'] as $index => $name) :
                                                ?>
                                                        <div id="guitarInfo" class="text">
                                                            <p class="text">
                                                                <?= $name ?> /
                                                                <?= $amps['brands'][$index] ?> /
                                                                <?= $amps['powers'][$index] ?>/
                                                                <?= $amps['technologies'][$index] ?>
                                                            </p>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                else :
                                                    echo '<p class="text"> Aucune Ampli ajoutée </p>';
                                                endif;
                                                ?>
                                            </div>
                                            <hr class="hrGear">
                                            <div id="pedalInfo">
                                                <p class="text">Pédales(s) :</p>
                                                <?php
                                                // Vérifier si des guitares sont disponibles pour cette musique
                                                if (isset($pedalsData[$trackName])) :
                                                    $pedals = $pedalsData[$trackName];
                                                    foreach ($pedals['names'] as $index => $name) :
                                                ?>
                                                        <div id="guitarInfo" class="text">
                                                            <p class="text">
                                                                <?= $pedals['effects'][$index] ?>/
                                                                <?= $name ?> /
                                                                <?= $pedals['brands'][$index] ?>

                                                            </p>
                                                        </div>
                                                <?php
                                                    endforeach;
                                                else :
                                                    echo '<p class="text"> Aucune Pédales ajoutée </p>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php } else{ echo '<p class="text">Aucune musique ajoutée</p>' ;} ?>
            <?php endif; ?>
        
        </article>
    </section>

    <!-- Affichage du matériel utilisé -->

    <?php
    // Affichage lien ajouter matériel si l'utilisateur est connecté
    if (isset($_SESSION['pseudo'])) { ?>
        <section class="bentoGuitarist">
            <a class='gear'>
                <h3 class='text title-gear'>Ajouter du matériel</h3>
            </a>
        <?php }

    // Affichage message d'erreur ou de réussite 
    if (isset($_SESSION["msgGuitar"])) {
        $message = $_SESSION["msgGuitar"];
        ?>
            <p class="text"><?php echo $message ?></p>
        <?php unset($_SESSION['msgGuitar']);
    }
        ?>
        <?php if (isset($_SESSION["msgAmp"])) {
            $message = $_SESSION["msgAmp"];
        ?>
            <p class="text"><?php echo $message ?></p>
        <?php unset($_SESSION['msgAmp']);
        } ?>
        <?php if (isset($_SESSION["msgPedal"])) {
            $message = $_SESSION["msgPedal"];
        ?>
            <p class="text"><?php echo $message ?></p>
        <?php unset($_SESSION['msgPedal']);
        } ?>

        <div id='modal-gear' class='modal'>
            <div class='modal-content bentoGuitarist'>
                <span class='close'>&times;</span>
                <h4 class='title'>Ajouter du matériel</h4>
                <div id="formGearGuitar" class="bento no-event">
                    <h5 class="title">Ajout de guitare</h5>
                    <div class="bentoBox boxHome">

                        <form id="addGearGuitar" class="conForm" action="?action=ProfilGuitariste" method="POST">
                            <select name="selectedMusic" class="selectMusic">
                                <option value="">Sélectionnez une musique</option>
                                <?php // Afficher les musiques triées par album dans le menu déroulant
                                foreach ($musicByAlbum as $album => $musics) {
                                    echo "<optgroup label='$album'>";
                                    foreach ($musics as $music) {
                                        echo "<option value='$music'>$music</option>";
                                    }
                                    echo "</optgroup>";
                                } ?>
                            </select>
                            <input type="text" name="nameG" placeholder="Nom du modèle" /><br>
                            <input type="text" name="brandG" placeholder="Marque" /><br>
                            <input type="text" name="yearG" placeholder="Année de sortie" /><br>
                            <input type="submit" classe value="Ajouter" />
                        </form>
                    </div>
                </div>
                <div id="formGearAmp" class="bento no-event">
                    <h5 class="title">Ajout d'ampli</h5>
                    <div class="bentoBox boxHome">

                        <form id="addGearAmp" class="conForm" action="#" method="POST">
                            <select name="selectedMusic" class="selectMusic">
                                <option value="">Sélectionnez une musique</option>
                                <?php // Afficher les musiques triées par album dans le menu déroulant
                                foreach ($musicByAlbum as $album => $musics) {
                                    echo "<optgroup label='$album'>";
                                    foreach ($musics as $music) {
                                        echo "<option value='$music'>$music</option>";
                                    }
                                    echo "</optgroup>";
                                } ?>
                            </select>
                            <input type="text" name="nameA" placeholder="Nom du modèle" /><br>
                            <input type="text" name="brandA" placeholder="Marque" /><br>
                            <input type="text" name="power" placeholder="Puissance" /><br>
                            <input type="text" name="techno" placeholder="Technologie" /><br>
                            <input type="submit" value="Ajouter" />
                        </form>
                    </div>
                </div>

                <div id="formGearPedal" class="bento no-event">
                    <h5 class="title">Ajout de pédale</h5>
                    <div class="bentoBox boxHome">

                        <form id="addGearPedal" class="conForm" action="#" method="POST">
                            <select name="selectedMusic" class="selectMusic">
                                <option value="">Sélectionnez une musique</option>
                                <?php // Afficher les musiques triées par album dans le menu déroulant
                                foreach ($musicByAlbum as $album => $musics) {
                                    echo "<optgroup label='$album'>";
                                    foreach ($musics as $music) {
                                        echo "<option value='$music'>$music</option>";
                                    }
                                    echo "</optgroup>";
                                } ?>
                            </select>
                            <input type="text" name="effect" placeholder="Effet" /><br>
                            <input type="text" name="nameP" placeholder="Nom du modèle" /><br>
                            <input type="text" name="brandP" placeholder="Marque" /><br>
                            <input type="submit" value="Ajouter" />
                        </form>
                    </div>
                </div>
        </section>

</main>


