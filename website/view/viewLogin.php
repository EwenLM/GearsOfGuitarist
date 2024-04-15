<main>
    <section id="formSignup" class="bento">
        <h2 class="title">Connexion</h2>
        <article class="bentoBox boxHome">

            <!-- Message d'erreur si l'authentification échoue -->
            <?php if(isset($_SESSION["msg"])){
                $message = $_SESSION["msg"];
            ?>
            <p class="text"><?php echo $message ?></p>
            <?php unset($_SESSION['msg']); } ?>
            
            <form id="formSignup" class="conForm" action="?action=Connexion" method="POST">
                <input type="text" name="pseudo" placeholder="Pseudo" /><br>
                <input type="password" name="password" placeholder="Mot de passe" /><br>

                <input type="submit" value="Se Connecter" />
            </form>

        </article>

    </section>
</main>