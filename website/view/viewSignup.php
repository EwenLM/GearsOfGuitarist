<main>

    <section id="formSignup" class="bento">
        <h2 class="title">Créer un compte</h2>
        <article class="bentoBox boxHome">
        <?php if(isset($_SESSION["msg"])){
                $message = $_SESSION["msg"];
            ?>
            <p class="text"><?php echo $message ?></p>
            <?php unset($_SESSION['msg']); } ?>
            <form id="formSignup" action="?action=Inscription" method="POST">
                <input type="text" name="pseudo" placeholder="Pseudo" /><br>
                <input type="mail" name="mail" placeholder="Email" /><br>
                <input type="password" name="password" placeholder="Mot de passe" /><br>

                <input type="submit" value="S'inscrire" />
            </form>
        </article>
    </section>
</main>