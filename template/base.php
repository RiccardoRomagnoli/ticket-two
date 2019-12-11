<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <title>
        <?php echo $templateParams["titolo"]; ?>
    </title>
</head>
<body>
    <header>
        <nav class="uk-navbar-container uk-margin" uk-navbar>
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
                <a class="uk-navbar-item uk-logo" href="./index.php"><h1>Ticket Two</h1></a>
            </div>
            <div class="uk-navbar-right nav-overlay">
                <a class="uk-navbar-item" href="#offcanvas-slide" uk-toggle><span class="uk-margin-small-right" uk-icon="icon: user"></span></a>
            </div>
        </nav>
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
    </main>
    <a href="#" uk-totop></a>
    <footer>
        <p>Tecnologie Web - A.A. 2019/2020</p>
    </footer>
</body>
</html>