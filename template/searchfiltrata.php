<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script src="js/ricerca.js"></script>
<input type="hidden" id="testoRicerca" value="<?php echo $_GET["ricerca"]; ?>"></input>
<div class="uk-section uk-section-default">
    <div class="uk-container">
        <h1>Ricerca Filtrata</h1>
            <ul uk-accordion>
                <li class="uk-open">
                    <a class="uk-accordion-title" href="#">Eventi</a>
                    <div class="uk-accordion-content">
                        <table id="tableRicercaEventi" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeEvento</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeEvento</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </li>
                <li>
                    <a class="uk-accordion-title" href="#">Artisti</a>
                    <div class="uk-accordion-content">
                        <table id="tableRicercaArtisti" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeArtista</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeArtista</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </li>
                <li>
                    <a class="uk-accordion-title" href="#">Luoghi</a>
                    <div class="uk-accordion-content">
                        <table id="tableRicercaLuoghi" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeLuogo</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>NomeLuogo</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </li>
            </ul>
    </div>
</div>