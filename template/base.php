<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/uikit.min.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/utils.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>  
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>

    <title>
        <?php echo $templateParams["titolo"]; ?>
    </title>
</head>
<body id="page-container">
    <div id="content-wrap">
        <header>
            <!-- Nav Superiore -->
            <nav class="uk-navbar-container uk-margin" uk-navbar uk-sticky="show-on-up: true">
                <!-- Search Bar -->
                <div class="nav-overlay uk-navbar-left uk-flex-1" hidden>
                    <div class="uk-navbar-item uk-width-expand">
                        <form class="uk-search uk-search-navbar uk-width-1-1">
                            <label for="searchBar" hidden>Search bar</label>
                            <input id="searchBar" class="uk-search-input" type="search" placeholder="Cerca Evento, Luogo, Autore..." autofocus>
                        </form>
                    </div>
                    <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#" title="searchbar"></a>
                </div>

                <!-- Nav Components -->
                <div class="uk-navbar-left nav-overlay">
                    <a class="uk-navbar-toggle" uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#" title="sideMenu"></a>
                </div>
                <div class="uk-navbar-center nav-overlay">
                    <a class="uk-navbar-item uk-logo" href="./index.php"><h1 class="uk-heading-small">Ticket Two</h1></a>
                </div>
                <div class="uk-navbar-right nav-overlay">
                    <a class="uk-navbar-item" href="#offcanvas-slide" uk-toggle><span class="uk-margin-small-right" uk-icon="icon: user"></span></a>
                </div>
            </nav>

            <!-- Off Canvas -->
            <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
                <div id="offcanvas-slide" uk-offcanvas="flip: true; overlay: true">
                    <div class="uk-offcanvas-bar">
                        <?php require_once("offcanvas.php"); ?>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?php
            if(isset($templateParams["nome"])){
                require($templateParams["nome"]);
            }
            ?>
        </main>
    </div>

    <!-- Footer -->
    <footer id="footer" class="uk-margin-top-meium uk-margin-bottom">
        <div class="uk-container uk-text-center">
            <div class="uk-child-width-auto@m uk-flex-middle uk-grid" uk-grid>
                <div class="uk-first-column">
                    <div class="uk-text-left@m uk-text-center">
                        <a href="./index.php" class="uk-logo">Ticket Two</a>
                    </div>
                </div>
                <div class="uk-margin-auto">
                    <ul uk-margin class="uk-subnav uk-flex-center">
                        <li class="uk-first-column"><a href="./whoWeAre.php">Chi siamo</a></li>
                        <li><a href="./mission.php">Mission</a></li>
                        <li><a href="./privacy.php">Privacy</a></li>
                        <li><a href="./contactUs.php">Contattaci</a></li>
                    </ul>
                </div>
                <div class>
                    <div class="uk-text-right@m uk-text-center">
                        <div uk-grid="" class="uk-child-width-auto uk-grid-small uk-flex-center uk-grid">
                            <div class="uk-first-column">
                                <a href="https://bitbucket.org/Tale97/tw_pulita_romagnoli_talmi/src/master/" uk-icon="icon: github" class="uk-icon-link uk-icon">Repo</a>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- To Top Arrow -->
    <div class="uk-margin uk-position-fixed uk-position-bottom-right uk-position-large">
        <a id="toTop" style="display: none" href="#" uk-scroll uk-totop title="scrollToTop"></a>
    </div>

    <?php require("login.php"); ?>
</body>
</html>