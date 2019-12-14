<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/utils.js"></script>

    <title>
        <?php echo $templateParams["titolo"]; ?>
    </title>
</head>
<body>
    <header>

        <!-- Nav Superiore -->
        <nav class="uk-navbar-container uk-margin" uk-navbar uk-sticky="show-on-up: true">
            <!-- Search Bar -->
            <div class="nav-overlay uk-navbar-left uk-flex-1" hidden>
                <div class="uk-navbar-item uk-width-expand">
                    <form class="uk-search uk-search-navbar uk-width-1-1">
                        <input class="uk-search-input" type="search" placeholder="Cerca evento, luogo, autore..." autofocus>
                    </form>
                </div>
                <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>
            </div>

            <div class="uk-navbar-left nav-overlay">
                <a class="uk-navbar-toggle" uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>
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

                    <ul class="uk-nav uk-nav-default">
                        <li class="uk-active"><a href="#">Active</a></li>
                        <li><a href="#">Item</a></li>
                        <li class="uk-nav-header">Header</li>
                        <li><a href="#">Item</a></li>
                        <li><a href="#">Item</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#">Item</a></li>
                    </ul>

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
<img data-src="https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=650&h=433&q=80"
     data-srcset="https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=650&h=433&q=80 650w,
                  https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=1300&h=866&q=80 1300w"
     sizes="(min-width: 650px) 650px, 100vw" width="650" height="433" alt="" uk-img>
     <img data-src="https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=650&h=433&q=80"
     data-srcset="https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=650&h=433&q=80 650w,
                  https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=1300&h=866&q=80 1300w"
     sizes="(min-width: 650px) 650px, 100vw" width="650" height="433" alt="" uk-img>
    </main>

    <!-- <footer class="uk-section uk-section-default uk-position-bottom uk-background-muted" uk-sticky>
            <p class="uk-position-center">Tecnologie Web - A.A. 2019/2020</p>
    </footer> -->

    <footer class="uk-margin-top uk-margin-bottom">
        <div class="uk-container uk-text-center">
            <div class="uk-child-width-auto@m uk-flex-middle uk-grid" uk-grid>
                <div class="uk-first-column">
                    <div class="uk-text-left@m uk-text-center">
                        <a href="./index.php" class="uk-logo">Ticket Two</a>
                    </div>
                </div>
                <div class="uk-margin-auto">
                    <ul uk-margin class="uk-subnav uk-flex-center">
                        <li class="uk-first-column"><a href="./blo">Bla</a></li>
                        <li><a href="./bli">Ble</a></li>
                        <li><a href="./ble">Bli</a></li>
                        <li><a href="./bla">Blo</a></li>
                    </ul>
                </div>
                <div class>
                    <div class="uk-text-right@m uk-text-center">
                        <div uk-grid="" class="uk-child-width-auto uk-grid-small uk-flex-center uk-grid">
                            <div class="uk-first-column">
                                <a href="https://github.com/" uk-icon="icon: github" class="uk-icon-link uk-icon">
                                </a>
                            </div> 
                            <div>
                                <a href="https://discordapp.com/" uk-icon="icon: commenting" class="uk-icon-link uk-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- To Top Arrow -->
    <div class="uk-margin">
        <a id="myBtn" style="display: none" href="#" uk-totop uk-scroll class="uk-position-fixed uk-position-bottom-right uk-position-large" ></a>
    </div>
</body>
</html>