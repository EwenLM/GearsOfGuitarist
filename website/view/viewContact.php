<main>
<section class="bento">

<div class="bentoBox boxHome">
    <h2 class="title">Nous contacter</h2>
    <p class="text"> Une problème, une suggestion ou autre n'hésitez pas à nous contacter</p> <br><br>
<?php if(isset($_SESSION['msgContact'])){ ?>
    <p class="text"><?php echo $_SESSION['msgContact'] ?></p>
<?php unset($_SESSION['msgContact']) ;} ?>
<form action="?action=Contact" method="post" class="conForm">

    <input class="inputForm" type="text" id="name" name="name" placeholder="Votre Pseudo">
    <input class="inputForm" type="email" id="email" name="email" placeholder="Votre Email" >
    <input class="inputForm" type="text" id="subject" name="subject" placeholder="Sujet" >
    <textarea class="inputForm" id="message" name="message" rows="6" cols="50" placeholder="Votres message"></textarea>
    
    <input class="btn" type="submit" value="Envoyer">

</form>
</div>
</section>


</main>