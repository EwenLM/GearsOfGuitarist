<body>
    <header id="header">
        <a href="?action=Accueil" class="logo">
            <h1>Gears of Guitarist.</h1>
        </a>
        <nav id="nav">
            <div id="menuToggle">
                <input type="checkbox">
                <!-- Span pour l'icone burger -->
                <span></span>
                <span></span>
                <span></span>

                <!-- Lien présent dans le menu -->
                <ul id="menu">
                    <li id="home">
                        <a href="?action=Accueil">
                            <p>Accueil</p>
                        </a>
                    </li>
                    <li id="guitarist">
                        <a href="?action=Guitariste">
                            <p>Guitariste</p>
                        </a>
                    </li>

                    <li id="profil">
                        <a href="?action=Profil">
                            <p>Profil</p>
                        </a>
                    </li>

                    <li id="contact">
                        <a href="?action=Contact">
                            <p>Contact</p>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="navCon">
                    <div id="loginLink">
                        <?php if (isset($_SESSION["pseudo"])) { ?>
                            <a class="text login" href="?action=Déconnexion">Déconnexion</a>
                        <?php } else { ?>
                            <a class="text login" href="?action=Connexion">Connexion</a>
                            <a class="text login" href="?action=Inscription">Inscription</a>
                        <?php } ?>
                        <?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) { ?>
                            <a class="text login" href="?action=Admin">Admin</a>
                        <?php } ?>
                    </div>
            </div>
        </nav>
    </header>