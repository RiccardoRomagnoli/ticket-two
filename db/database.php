<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        $this->db->set_charset("utf8");
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    public function getUserRecover($mail){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Utente
                                    WHERE ? = Mail");
        $stmt->bind_param('s',$mail);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updatePassword($Password, $IdUtente){
        $query = "UPDATE Utente SET Password = ? WHERE IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si',$Password, $IdUtente);
        
        return $stmt->execute();
    }

    public function getUser($mail, $password){
        $stmt = $this->db->prepare("SELECT *, TipoUtente.Nome AS TipoUtente, Utente.Nome AS Nome 
                                    FROM Utente INNER JOIN TipoUtente ON Utente.IdTipoUtente = TipoUtente.IdTipoUtente 
                                    WHERE ? = Mail AND ? = Password");
        $stmt->bind_param('ss',$mail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id){
        $stmt = $this->db->prepare("SELECT *, TipoUtente.Nome AS TipoUtente, Utente.Nome AS Nome 
                                    FROM Utente INNER JOIN TipoUtente ON Utente.IdTipoUtente = TipoUtente.IdTipoUtente 
                                    WHERE IdUtente = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertUser($name, $surname, $mail, $password){
        $idTypeUser = 3;
        $query = "INSERT INTO Utente (IdTipoUtente, Nome, Cognome, Mail, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $idTypeUser, $name, $surname, $mail, $password);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function insertCreator($name, $surname, $mail, $password){
        $idTypeUser = 2;
        $query = "INSERT INTO Utente (IdTipoUtente, Nome, Cognome, Mail, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $idTypeUser, $name, $surname, $mail, $password);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function getArtistById($id){
        $stmt = $this->db->prepare("SELECT * FROM Artista WHERE IdArtista = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdUserThatBuyedTicket($id){
        $stmt = $this->db->prepare(
            "SELECT IdEvento, Titolo, Locandina
            FROM Evento 
            WHERE IdEvento IN 
            (SELECT DISTINCT Evento.IdEvento as IdEvento
            FROM Evento, Sezione, Biglietto, RigaAcquisto, Acquisto
            WHERE Evento.IdEvento = Sezione.IdEvento and Sezione.IdSezione = Biglietto.IdSezione and Biglietto.IdBiglietto = RigaAcquisto.IdBiglietto and RigaAcquisto.IdAcquisto = Acquisto.IdAcquisto and Acquisto.IdUtente = ?)
            ORDER BY DataInizio");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdArtist($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Locandina as Locandina, Evento.DataInizio as DataInizio, Evento.DataFine as DataFine, Citta.Nome as NomeCitta
            FROM ArtistaEvento, Evento, Luogo, Citta
            WHERE Evento.IdEvento = ArtistaEvento.IdEvento and Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta and ArtistaEvento.IdArtista = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFollowedEventsByIdUser($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                 Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, EventoSeguito, Luogo, Citta
            WHERE Evento.IdEvento = EventoSeguito.IdEvento 
            and Evento.IdLuogo = Luogo.IdLuogo 
            and Luogo.IdCitta = Citta.IdCitta
            and EventoSeguito.IdUtente = ?
            and DataInizio >= CURDATE()");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategories(){
        $stmt = $this->db->prepare(
            "SELECT *
            FROM Categoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserNotificationsNotReaded($id){
        $stmt = $this->db->prepare(
            "SELECT * 
            FROM Notifica
            WHERE IdUtente = ? 
                AND Letto = 0
            ORDER BY IdNotifica DESC");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserNotificationsAlreadyReaded($id){
        $stmt = $this->db->prepare(
            "SELECT * 
            FROM Notifica
            WHERE IdUtente = ? 
                AND Letto = 1
            ORDER BY IdNotifica DESC");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function changeNotificationToReaded($idNotification){
        $query = "UPDATE Notifica SET Letto = 1 WHERE IdNotifica = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idNotification);
        
        return $stmt->execute();
    }

    public function deleteNotification($idNotification){
        $query = "DELETE FROM Notifica WHERE IdNotifica = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idNotification);
        
        return $stmt->execute();
    }

    public function getLatestTenEventsByCategory($idCategory){
        $stmt = $this->db->prepare(
            "SELECT
                Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta, CategoriaEvento
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.IdEvento = CategoriaEvento.IdEvento
                and CategoriaEvento.IdCategoria = ?
                and Evento.DataInizio >= CURDATE()
            ORDER BY Evento.IdEvento DESC LIMIT 10");
        $stmt->bind_param('i', $idCategory);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNRandomValidEventsExceptSomeEvents($n, $events){
        $build = 
            "SELECT Evento.*, Citta.Nome as NomeCitta
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.DataInizio >= CURDATE() ";
        foreach($events as $event):
            $build = $build . ' and Evento.IdEvento != ' . $event["IdEvento"];
        endforeach;
        $build = $build . " ORDER BY RAND() LIMIT ?";
        $stmt = $this->db->prepare($build);
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTenValidRandomEvents(){
        $stmt = $this->db->prepare(
            "SELECT Evento.*, Citta.Nome as NomeCitta
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.DataInizio >= CURDATE()
            ORDER BY RAND() LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTenRandomValidInterestEvents($idUser){
        $stmt = $this->db->prepare(
            "SELECT Evento.*, Citta.Nome as NomeCitta
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.DataInizio >= CURDATE()
                and Evento.IdEvento IN 
                    (SELECT DISTINCT IdEvento
                    FROM CategoriaEvento
                    WHERE IDCategoria IN 
                        (SELECT IdCategoria
                        FROM CategoriaSeguita
                        WHERE IdUtente = ?))
            ORDER BY RAND() LIMIT 10");
        $stmt->bind_param('i', $idUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestTenEvents(){
        $stmt = $this->db->prepare(
            "SELECT Evento.*, Citta.Nome as NomeCitta
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.DataInizio >= CURDATE()
            ORDER BY Evento.IdEvento DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCreatedEventsByIdUserCreator($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                 Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
            and Luogo.IdCitta = Citta.IdCitta
            and Evento.IdUtente = ?
            ORDER BY Evento.IdEvento DESC");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestTenCreatedEventsByIdUserCreator($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                 Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
            and Luogo.IdCitta = Citta.IdCitta
            and Evento.IdUtente = ?
            ORDER BY Evento.IdEvento DESC limit 10");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestTenEventsSimilarToMyOrganizedEvents($idUser){
        $myEvents = "SELECT IdEvento FROM Evento WHERE IdUtente = ? ";
        $categoriesOfMyEvents = "SELECT DISTINCT IdCategoria FROM CategoriaEvento WHERE IdEvento IN (" . $myEvents . ")";
        $idEventsMatchingMyCategoriesExcludingMyEvents = 
            "SELECT DISTINCT IdEvento 
            FROM CategoriaEvento
            WHERE IdEvento NOT IN (" . $myEvents . ") AND IdCategoria IN (" . $categoriesOfMyEvents . ")";
        $latestTenEventsSimilarToMine = 
            "SELECT Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
            Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
            Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
            and Luogo.IdCitta = Citta.IdCitta
            and Evento.IdEvento IN (" . $idEventsMatchingMyCategoriesExcludingMyEvents . ") 
            ORDER BY Evento.IdEvento DESC limit 10";
        $stmt = $this->db->prepare($latestTenEventsSimilarToMine);
        $stmt->bind_param('ii', $idUser, $idUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPlaceById($id){
        $stmt = $this->db->prepare("SELECT Luogo.*, Citta.Nome as NomeCitta, Provincia.Nome as NomeProvincia, Regione.Nome as NomeRegione FROM Luogo, Citta, Regione, Provincia WHERE IdLuogo = ? and Luogo.IdCitta = Citta.IdCitta and Citta.IdProvincia = Provincia.IdProvincia and Provincia.IdRegione = Regione.IdRegione");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdPlace($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Locandina as Locandina, Evento.DataInizio as DataInizio, Evento.DataFine as DataFine, Citta.Nome as NomeCitta
            FROM Evento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta and Luogo.IdLuogo = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdEvento($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.IdEvento as IdEvento, Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                 Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo,
                 Evento.IdLuogo as IdLuogo, Evento.IdUtente as IdUtente
            FROM Evento, Luogo, Citta
            WHERE Evento.IdEvento = ? and Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPurchasedTicketsByIdUserAndIdEvent($idUser, $idEvent){
        $stmt = $this->db->prepare(
            "SELECT RigaAcquisto.Nome as Nome, RigaAcquisto.Cognome as Cognome, RigaAcquisto.DataNascita as DataNascita, RigaAcquisto.Importo as Importo,
                TipoBiglietto.Nome as TipoBiglietto, Sezione.Nome as Sezione, Biglietto.DataInizio as DataInizio, Biglietto.DataFine as DataFine, Biglietto.Orario as Orario
            FROM Acquisto, RigaAcquisto, Biglietto, Sezione, TipoBiglietto
            WHERE Acquisto.IdAcquisto = RigaAcquisto.IdAcquisto AND RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto AND
                Biglietto.IdSezione = Sezione.IdSezione AND Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto AND
                Sezione.IdEvento = ? AND Acquisto.IdUtente = ? AND RigaAcquisto.Nome != \"\" AND RigaAcquisto.Cognome != \"\"");
        $stmt->bind_param('ii', $idEvent, $idUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReports(){
        $stmt = $this->db->prepare(
            "SELECT Segnalazione.*, Evento.Titolo 
            FROM Segnalazione, Evento
            WHERE Segnalazione.IdEvento = Evento.IdEvento
            ORDER BY IdSegnalazione DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkIfUserFollowArtist($idUser, $idArtist){
        $query = "SELECT * FROM ArtistaSeguito WHERE IdArtista = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idArtist, $idUser);
        $stmt->execute();
        return (count($stmt->get_result()->fetch_all(MYSQLI_ASSOC)) > 0);
    }

    public function checkIfUserFollowPlace($idUser, $idPlace){
        $query = "SELECT * FROM LuogoSeguito WHERE IdLuogo = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idPlace, $idUser);
        $stmt->execute();
        return (count($stmt->get_result()->fetch_all(MYSQLI_ASSOC)) > 0);
    }

    public function insertFollowArtist($idUser, $idArtist){
        $query = "INSERT INTO ArtistaSeguito (IdArtista, IdUtente) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idArtist, $idUser);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function insertFollowPlace($idUser, $idPlace){
        $query = "INSERT INTO LuogoSeguito (IdLuogo, IdUtente) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idPlace, $idUser);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function deleteFollowArtist($idUser, $idArtist){
        $query = "DELETE FROM ArtistaSeguito WHERE IdArtista = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idArtist, $idUser);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function deleteFollowPlace($idUser, $idPlace){
        $query = "DELETE FROM LuogoSeguito WHERE IdLuogo = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idPlace, $idUser);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function getEventCategoriesByIdEvento($id){
        $stmt = $this->db->prepare(
            "SELECT Categoria.Nome, Categoria.IdCategoria
            FROM Evento INNER JOIN CategoriaEvento ON Evento.IdEvento = CategoriaEvento.IdEvento 
                INNER JOIN Categoria ON Categoria.IdCategoria = CategoriaEvento.IdCategoria 
            WHERE Evento.IdEvento = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventArtistsByIdEvento($id){
        $stmt = $this->db->prepare(
            "SELECT Artista.Nome, Artista.IdArtista
            FROM Evento INNER JOIN ArtistaEvento ON Evento.IdEvento = ArtistaEvento.IdEvento 
                INNER JOIN Artista ON Artista.IdArtista = ArtistaEvento.IdArtista 
            WHERE Evento.IdEvento = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getEventTicketsByIdEvento($id){
        $stmt = $this->db->prepare(
            "SELECT Sezione.Nome AS NomeSezione, Sezione.PostiTotali AS PostiTotali, Biglietto.Prezzo as PrezzoBiglietto,
                Biglietto.DataInizio as DataInizioBiglietto, Biglietto.DataFine as DataFineBiglietto, TipoBiglietto.Nome as NomeBiglietto,
                Biglietto.IdBiglietto as IdBiglietto, Biglietto.IdSezione as IdSezione, Biglietto.Orario as Orario
            FROM Evento INNER JOIN Sezione ON Evento.IdEvento = Sezione.IdEvento 
                INNER JOIN Biglietto ON Biglietto.IdSezione = Sezione.IdSezione 
                INNER JOIN TipoBiglietto ON Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto 
            WHERE Evento.IdEvento = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPaymentCards($idUser){
        $stmt = $this->db->prepare("SELECT *, YEAR(MetodoPagamento.DataScadenza) AS Anno, MONTH(MetodoPagamento.DataScadenza) AS Mese
                                    FROM Utente INNER JOIN MetodoPagamento ON Utente.IdUtente = MetodoPagamento.IdUtente
                                    WHERE Utente.IdUtente = ?");
        $stmt->bind_param('i', $idUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInterests($idUser){
        $stmt = $this->db->prepare("SELECT *, Categoria.Nome As NomeCategoria
                                    FROM Utente INNER JOIN CategoriaSeguita ON Utente.IdUtente = CategoriaSeguita.IdUtente 
                                                INNER JOIN Categoria ON Categoria.IdCategoria = CategoriaSeguita.IdCategoria
                                    WHERE Utente.IdUtente = ?");
        $stmt->bind_param('i', $idUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllInterests(){
        $stmt = $this->db->prepare("SELECT Nome AS NomeCategoria FROM Categoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removePayment($IdPayment){
        $query = "DELETE FROM MetodoPagamento WHERE IdMetodoPagamento = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$IdPayment);
        $stmt->execute();
        return $result = $stmt->get_result();
    }

    public function removeInterest($IdInterest, $IdUser){
        $query = "DELETE FROM CategoriaSeguita WHERE IdCategoria = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$IdInterest, $IdUser);
        $stmt->execute();
        return $result = $stmt->get_result();
    }

    public function addInterest($IdInterest, $IdUser){
        $query = "INSERT INTO CategoriaSeguita (IdUtente, IdCategoria) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$IdUser, $IdInterest);
        $stmt->execute();
        return $result = $stmt->get_result();
    }

    public function insertPayment($Titolare, $Data, $Numero, $IdUtente){
        $query = "INSERT INTO MetodoPagamento (IdUtente, NumeroCarta, DataScadenza, Titolare) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isss', $IdUtente, $Numero, $Data, $Titolare);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function updateUser($Nome, $Cognome, $Email, $Password, $IdUtente){
        $query = "UPDATE Utente SET Nome = ?, Cognome = ?, Password = ?, Mail = ? WHERE IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssi', $Nome, $Cognome, $Password, $Email, $IdUtente);
        
        return $stmt->execute();
    }

    public function getCartByUser($IdUser){
        $stmt = $this->db->prepare("SELECT *, TipoBiglietto.Nome AS NomeTipo, Sezione.Nome AS NomeSezione, RigaAcquisto.Nome AS NomeReferente
                                    FROM Acquisto INNER JOIN RigaAcquisto ON Acquisto.IdAcquisto = RigaAcquisto.IdAcquisto 
                                                  INNER JOIN Biglietto ON RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto
                                                  INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdSezione
                                                  INNER JOIN Evento ON Evento.IdEvento = Sezione.IdEvento
                                                  INNER JOIN TipoBiglietto ON Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
                                    WHERE Acquisto.IdUtente = ? AND Acquisto.Data IS NULL");
        $stmt->bind_param('i', $IdUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCartByCart($IdCart){
        $stmt = $this->db->prepare("SELECT *, TipoBiglietto.Nome AS NomeTipo, Sezione.Nome AS NomeSezione, RigaAcquisto.Nome AS NomeReferente
                                    FROM Acquisto INNER JOIN RigaAcquisto ON Acquisto.IdAcquisto = RigaAcquisto.IdAcquisto 
                                                  INNER JOIN Biglietto ON RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto
                                                  INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdSezione
                                                  INNER JOIN Evento On Evento.IdEvento = Sezione.IdEvento
                                                  INNER JOIN TipoBiglietto On Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
                                    WHERE Acquisto.IdAcquisto = ? AND Acquisto.Data IS NULL");
        $stmt->bind_param('i', $IdCart);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateCart($IdRiga, $Nome, $Cognome, $DataNascita){
        $query = "UPDATE RigaAcquisto SET Nome = ?, Cognome = ?, DataNascita = ? WHERE IdRigaAcquisto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $Nome, $Cognome, $DataNascita, $IdRiga);
        
        return $stmt->execute();
    }

    public function removeCart($IdRigaCarrello){
        $query = "DELETE FROM RigaAcquisto WHERE IdRigaAcquisto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$IdRigaCarrello);
        $stmt->execute();
        return $result = $stmt->get_result();
    }

    public function updateArtist($idArtist, $name, $description, $photoFileName){
        $query = "UPDATE Artista SET Nome = ?, Descrizione = ?, Foto = ? WHERE IdArtista = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $name, $description, $photoFileName, $idArtist);
        
        return $stmt->execute();
    }

    public function updatePlace($idPlace, $name, $description){
        $query = "UPDATE Luogo SET Nome = ?, Descrizione = ? WHERE IdLuogo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $name, $description, $idPlace);
        
        return $stmt->execute();
    }

    public function deleteArtist($idArtist){
        $query = "DELETE FROM ArtistaSeguito WHERE IdArtista = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idArtist);
        $stmt->execute();
        $query = "DELETE FROM ArtistaEvento WHERE IdArtista = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idArtist);
        $stmt->execute();
        $query = "DELETE FROM Artista WHERE IdArtista = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idArtist);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function deletePlace($idPlace){
        $query = "DELETE FROM LuogoSeguito WHERE IdLuogo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idPlace);
        $stmt->execute();
        $query = "DELETE FROM Luogo WHERE IdLuogo = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idPlace);
        $stmt->execute();
        
        return $stmt->insert_id;
    }
    
    public function isEventFollowed($IdUser, $IdEvent){
        $stmt = $this->db->prepare("SELECT * 
                                    FROM EventoSeguito 
                                    WHERE IdUtente = ? AND IdEvento = ?");
        $stmt->bind_param('ii', $IdUser, $IdEvent);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) == 1;
    }

    public function follow($IdUser, $IdEvent){
        $query = "INSERT INTO EventoSeguito (IdUtente, IdEvento) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $IdUser, $IdEvent);
        return $stmt->execute();
    }

    public function unFollow($IdUser, $IdEvent){
        $query = "DELETE FROM EventoSeguito WHERE IdUtente = ? AND IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $IdUser, $IdEvent);
        return $stmt->execute();
    }

    public function getCartOpen($IdUser) {
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Acquisto 
                                    WHERE IdUtente = ? AND Data IS NULL");
        $stmt->bind_param('i', $IdUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function creaCart($IdUser){
        $query = "INSERT INTO Acquisto (IdUtente) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdUser);
        $stmt->execute();

        $stmt = $this->db->prepare("SELECT * 
                                    FROM Acquisto 
                                    WHERE IdUtente = ? AND Data IS NULL");
        $stmt->bind_param('i', $IdUser);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function creaCartGuest(){
        $query = "INSERT INTO Acquisto () VALUES ()";
        $stmt = $this->db->prepare($query);
        $stmt->execute(); 
        return $stmt->insert_id;
    }

    public function creaRigaAcquisto($IdCart, $IdBiglietto){
        $query = "INSERT INTO RigaAcquisto (IdAcquisto, IdBiglietto) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $IdCart, $IdBiglietto);
        return $stmt->execute();
    }

    public function doPaymentGuest($IdAcquisto, $Email, $CVC){
        $idTypeUser = 3;
        $date = date("Y-m-d");
        $info = "Guest";
        
        $query = "INSERT INTO Utente (IdTipoUtente, Nome, Cognome, Mail, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $idTypeUser, $info, $info, $Email, $info);
        $stmt->execute();

        $id = $stmt->insert_id;

        $query = "UPDATE Acquisto SET Data = ?, IdUtente = ? WHERE IdAcquisto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sii', $date, $id, $IdAcquisto);
        $stmt->execute();
        
        return $id;
    }

    public function doPaymentUser($IdAcquisto, $CVC){
        $date = date("Y-m-d");

        $query = "UPDATE Acquisto SET Data = ? WHERE IdAcquisto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $date, $IdAcquisto);
        
        return $stmt->execute();
    }

    public function registerGuest($Password, $IdGuest){
        $query = "UPDATE Utente SET Password = ? WHERE IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $Password, $IdGuest);
        
        return $IdGuest;
    }

    public function singupCart($IdUser, $IdCart){
        $query = "UPDATE Acquisto SET IdUtente = ? WHERE IdAcquisto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $IdUser, $IdCart);
        
        return $stmt->execute();
    }

    public function getUserByCart($IdAcquisto){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Acquisto INNER JOIN Utente ON Acquisto.IdUtente = Utente.IdUtente 
                                    WHERE Acquisto.IdAcquisto = ?");
        $stmt->bind_param('i', $IdAcquisto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);    
    }

    public function getCartToPrint($IdUser){
        $stmt = $this->db->prepare("SELECT RigaAcquisto.Nome AS NomeReferente, RigaAcquisto.Cognome AS CognomeReferente, RigaAcquisto.DataNascita AS DataReferente,
                                           Evento.Titolo, Evento.DataInizio, TipoBiglietto.Nome AS NomeTipo, Sezione.Nome AS NomeSezione, RigaAcquisto.IdRigaAcquisto AS Barcode 
                                    FROM Acquisto INNER JOIN RigaAcquisto ON Acquisto.IdAcquisto = RigaAcquisto.IdAcquisto 
                                                  INNER JOIN Biglietto ON RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto
                                                  INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdSezione
                                                  INNER JOIN Evento ON Evento.IdEvento = Sezione.IdEvento
                                                  INNER JOIN TipoBiglietto ON Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
                                    WHERE Acquisto.IdAcquisto = ?");
        $stmt->bind_param('i', $IdUser);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getLuoghi(){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Luogo");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTipoBiglietti(){
        $stmt = $this->db->prepare("SELECT *
                                    FROM TipoBiglietto");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function modificaEvento($idEvento, $titolo, $fotoLocation, $idLuogo, $dataInizio, $dataFine, $descrizione) {
        $query = "UPDATE Evento SET IdLuogo = ?, Titolo = ?, Descrizione = ?, Locandina = ?, DataInizio = ?, DataFine = ? WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isssssi', $idLuogo, $titolo, $descrizione, $fotoLocation, $dataInizio, $dataFine, $idEvento);
        $result = $stmt->execute();

        if(!empty($idEvento)){
            //aggiungi notifica per chi segue l'evento

            //prendi tutti gli utenti che seguono l'evento
            $query = "SELECT IdUtente FROM EventoSeguito WHERE IdEvento = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idEvento);
            $stmt->execute();
            $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($idUtenti as $idUtente) {
                $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                $stmt = $this->db->prepare($query);
                $messaggio = "E' stato modificato un evento che segui.";
                $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                $stmt->execute();
            }
        }
        return $result;
    }

    public function eliminaEvento($idEvento) {
        $query = "DELETE FROM Evento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idEvento);
        return $stmt->execute();
    }

    public function getTicketSezionePresi($idSezione, $dataInizio, $dataFine, $orario){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS 'PostiOccupati' 
                                    FROM `RigaAcquisto` INNER JOIN Biglietto ON RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto 
                                    WHERE Biglietto.IdSezione = ? && 
                                        ((Biglietto.DataInizio = ? && Biglietto.DataFine = ? && Biglietto.Orario = ?) 
                                        || (Biglietto.DataInizio <= ? && Biglietto.DataFine >= ?)) 
                                    GROUP BY Biglietto.IdSezione");
        $stmt->bind_param('isssss', $idSezione, $dataInizio, $dataFine, $orario, $dataInizio, $dataFine);
        $stmt->execute();
        $result = $stmt->get_result();
        $exitResult = $result->fetch_all(MYSQLI_ASSOC);
        if(empty($exitResult)){
            return array(array('PostiOccupati' => 0));
        }
        return $exitResult;
    }

    public function getAbbonamentoSezionePresi($idSezione, $dataInizio, $dataFine){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS 'PostiOccupati' 
                                    FROM RigaAcquisto INNER JOIN Biglietto ON RigaAcquisto.IdBiglietto = Biglietto.IdBiglietto 
                                    WHERE Biglietto.IdSezione = ? && (Biglietto.DataInizio >= ? && Biglietto.DataFine <= ?)
                                    GROUP BY Biglietto.IdSezione");
        $stmt->bind_param('iss', $idSezione, $dataInizio, $dataFine);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInfoBiglietto($idBiglietto){

        $stmt = $this->db->prepare("SELECT Biglietto.IdTipoBiglietto as IdTipoBiglietto, Prezzo, DataInizio, DataFine, Orario, Sezione.IdSezione as IdSezioneEvento
                                    FROM Biglietto INNER JOIN TipoBiglietto ON TipoBiglietto.IdTipoBiglietto = Biglietto.IdTipoBiglietto 
                                    INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdSezione
                                    WHERE Biglietto.IdBiglietto = ?");
        $stmt->bind_param('i', $idBiglietto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function modificaBiglietto($idBiglietto, $idSezioneEvento, $dataInizioBiglietto, $dataFineBiglietto, $idTipoBiglietto, $orarioBiglietto, $prezzoBiglietto){
        $query = "UPDATE Biglietto SET IdSezione = ?, IdTipoBiglietto = ?, Prezzo = ?, DataInizio = ?, DataFine = ?, Orario = ? WHERE IdBiglietto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iidsssi', $idSezioneEvento, $idTipoBiglietto, $prezzoBiglietto, $dataInizioBiglietto, $dataFineBiglietto, $orarioBiglietto, $idBiglietto);
        return $stmt->execute();
    }

    public function getSezioni($idEvento){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Sezione
                                    WHERE IdEvento = ?");
        $stmt->bind_param('i', $idEvento);           
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInfoSezione($idSezione){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Sezione
                                    WHERE IdSezione = ?");
        $stmt->bind_param('i', $idSezione);           
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function modificaSezione($idSezione, $nomeSezione, $postiTotali){
        $query = "UPDATE Sezione SET Nome = ?, PostiTotali = ? WHERE IdSezione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sii', $nomeSezione, $postiTotali, $idSezione);
        return $stmt->execute();
    }

    public function eliminaBiglietto($idBiglietto){
        $query = "DELETE FROM Biglietto WHERE IdBiglietto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idBiglietto);
        return $stmt->execute();
    }

    public function addBiglietto($idSezioneEvento, $dataInizioBiglietto, $dataFineBiglietto, $idTipoBiglietto, $orarioBiglietto, $prezzoBiglietto){
        $query = "INSERT INTO Biglietto (IdSezione, IdTipoBiglietto, Prezzo, DataInizio, DataFine, Orario) VALUE (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iidsss', $idSezioneEvento, $idTipoBiglietto, $prezzoBiglietto, $dataInizioBiglietto, $dataFineBiglietto, $orarioBiglietto);
        $result = $stmt->execute();
        if(!empty($idSezioneEvento)){
            //aggiungi notifica per gli seguono l'evento

            //prendo l'evento della sezione
            $query = "SELECT IdEvento FROM Sezione WHERE IdSezione = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idSezioneEvento);
            $stmt->execute();
            $idEventi = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            //per ogni evento, in pratica è solo 1
            foreach ($idEventi as $idEvento) {
                //prendi tutti gli utenti che seguono l'evento
                $query = "SELECT IdUtente FROM EventoSeguito WHERE IdEvento = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $idEvento["IdEvento"]);
                $stmt->execute();
                $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                foreach ($idUtenti as $idUtente) {
                    $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                    $stmt = $this->db->prepare($query);
                    $messaggio = "E' stato aggiunto un nuovo biglietto ad un evento che segui.";
                    $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                    $stmt->execute();
                }
            }
        }
        return $result;
    }

    public function modificaEventoNoImage($idEvento, $titolo, $idLuogo, $dataInizio, $dataFine, $descrizione){
        $query = "UPDATE Evento SET IdLuogo = ?, Titolo = ?, Descrizione = ?, DataInizio = ?, DataFine = ? WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issssi', $idLuogo, $titolo, $descrizione, $dataInizio, $dataFine, $idEvento);
        $result = $stmt->execute();

        if(!empty($idEvento)){
            //aggiungi notifica per chi segue l'evento

            //prendi tutti gli utenti che seguono l'evento
            $query = "SELECT IdUtente FROM EventoSeguito WHERE IdEvento = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idEvento);
            $stmt->execute();

            $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            foreach ($idUtenti as $idUtente) {
                $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                $stmt = $this->db->prepare($query);
                $messaggio = "E' stato modificato un evento che segui.";
                $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                $stmt->execute();
            }
        }
        return $result;
    }

    public function getRegione(){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Regione");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProvinciaFromRegione($idregione){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Provincia
                                    WHERE IdRegione = ?");
        $stmt->bind_param('i', $idregione);  
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCittaFromProvincia($idprovincia){
        $stmt = $this->db->prepare("SELECT *
                                    FROM Citta
                                    WHERE IdProvincia = ?");
        $stmt->bind_param('i', $idprovincia);  
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addLuogo($idCitta, $nomeLuogo, $descrizioneLuogo){
        $query = "INSERT INTO Luogo (IdCitta, Nome, Descrizione) VALUE (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $idCitta, $nomeLuogo, $descrizioneLuogo);
        $stmt->execute();
        $idLuogo = $stmt->insert_id;

        $query = "SELECT Nome FROM Luogo WHERE IdLuogo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idLuogo);
        $stmt->execute();
        $result = $stmt->get_result();
        return array($idLuogo, ($result->fetch_all(MYSQLI_ASSOC))[0]["Nome"]);
    }

    public function aggiungiSezione($idEvento, $nomeSezione, $postiTotali){
        $query = "INSERT INTO Sezione (IdEvento, Nome, PostiTotali) VALUE (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $idEvento, $nomeSezione, $postiTotali);
        $stmt->execute();
        $idSezione = $stmt->insert_id;

        $query = "SELECT Nome FROM Sezione WHERE IdSezione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idSezione);
        $stmt->execute();
        $result = $stmt->get_result();
        return array($idSezione, ($result->fetch_all(MYSQLI_ASSOC))[0]["Nome"]);
    }

    public function getLuogoEvento($idEvento){
        $stmt = $this->db->prepare("SELECT Luogo.Nome, Luogo.IdLuogo
                                    FROM Evento INNER JOIN Luogo ON Evento.IdLuogo = Luogo.IdLuogo
                                    WHERE Evento.IdEvento = ?");
        $stmt->bind_param('i', $idEvento);                           
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLuoghiNonEvento($idevento){
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Luogo
                                    WHERE Luogo.IdLuogo 
                                        NOT IN (SELECT Evento.IdLuogo 
                                                FROM Evento 
                                                WHERE Evento.IdEvento = ?)");
        $stmt->bind_param('i', $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArtisti(){
        $stmt = $this->db->prepare("SELECT Nome, IdArtista
                                    FROM Artista");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArtistiNonEvento($idevento){
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Artista
                                    WHERE Artista.IdArtista 
                                        NOT IN (SELECT ArtistaEvento.IdArtista 
                                                FROM Evento INNER JOIN ArtistaEvento ON Evento.IdEvento = ArtistaEvento.IdEvento 
                                                WHERE Evento.IdEvento = ?)");
        $stmt->bind_param('i', $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategorieNonEvento($idevento){
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Categoria
                                    WHERE  Categoria.IdCategoria 
                                        NOT IN (SELECT CategoriaEvento.IdCategoria 
                                                FROM Evento INNER JOIN CategoriaEvento ON Evento.IdEvento = CategoriaEvento.IdEvento 
                                                WHERE Evento.IdEvento = ?)");
        $stmt->bind_param('i', $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSezioneBiglietto($idbiglietto){
        $stmt = $this->db->prepare("SELECT Sezione.IdSezione, Sezione.Nome
                                    FROM Biglietto INNER JOIN Sezione ON Biglietto.IdSezione = Sezione.IdSezione
                                    WHERE Biglietto.IdBiglietto = ?");
        $stmt->bind_param('i', $idbiglietto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSezioneNonBiglietto($idbiglietto){
        $stmt = $this->db->prepare("SELECT Sezione.IdSezione, Sezione.Nome 
                                    FROM Sezione
                                    WHERE Sezione.IdSezione 
                                        NOT IN (SELECT Sezione.IdSezione
                                                FROM Biglietto INNER JOIN Sezione ON Biglietto.IdSezione = Sezione.IdSezione
                                                WHERE Biglietto.IdBiglietto = ?)");
        $stmt->bind_param('i', $idbiglietto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTipoBiglietto($idbiglietto){
        $stmt = $this->db->prepare("SELECT TipoBiglietto.IdTipoBiglietto, TipoBiglietto.Nome
                                    FROM Biglietto INNER JOIN TipoBiglietto ON Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
                                    WHERE Biglietto.IdBiglietto = ?");
        $stmt->bind_param('i', $idbiglietto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTipoNonBiglietto($idbiglietto){
        $stmt = $this->db->prepare("SELECT TipoBiglietto.IdTipoBiglietto, TipoBiglietto.Nome
                                    FROM TipoBiglietto
                                    WHERE  TipoBiglietto.IdTipoBiglietto 
                                        NOT IN (SELECT TipoBiglietto.IdTipoBiglietto
                                                FROM Biglietto INNER JOIN TipoBiglietto ON Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
                                                WHERE Biglietto.IdBiglietto = ?)");
        $stmt->bind_param('i', $idbiglietto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aggiungiCategoriaEvento($idEvento, $idCategoria){
        $query = "INSERT INTO CategoriaEvento (IdEvento, IdCategoria) VALUE (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idEvento, $idCategoria);
        return $stmt->execute();
    }

    public function aggiungiArtistaEvento($idEvento, $idArtista){
        $query = "INSERT INTO ArtistaEvento (IdEvento, IdArtista) VALUE (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $idEvento, $idArtista);
        return $stmt->execute();
    }

    public function cancellaCategorieEvento($idEvento){
        $query = "DELETE FROM CategoriaEvento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idEvento);
        return $stmt->execute();
    }

    public function cancellaArtistiEvento($idEvento){
        $query = "DELETE FROM ArtistaEvento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idEvento);
        return $stmt->execute();
    }

    public function aggiungiArtista($nomeArtista, $descrizioneArtista, $pathArtista){
        $query = "INSERT INTO Artista (Nome, Descrizione, Foto) VALUE (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $nomeArtista, $descrizioneArtista, $pathArtista);
        $stmt->execute();
        $idArtista = $stmt->insert_id;

        $query = "SELECT Nome FROM Artista WHERE IdArtista = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idArtista);
        $stmt->execute();
        $result = $stmt->get_result();
        return array($idArtista, ($result->fetch_all(MYSQLI_ASSOC))[0]["Nome"]);
    }

    public function aggiungiEvento($titolo, $pathLocandina, $idLuogo, $dataInizio, $dataFine, $descrizione, $idUtente){
        $query = "INSERT INTO Evento (Titolo, Descrizione, Locandina, DataInizio, DataFine, IdLuogo, IdUtente) VALUE (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssii', $titolo, $descrizione, $pathLocandina, $dataInizio, $dataFine, $idLuogo, $idUtente);
        $stmt->execute();
        $idEvento = $stmt->insert_id;
        //se effettivamente l'ho aggiunto
        if(!empty($idEvento)){
            //aggiungi notifica per gli utenti che seguono il luogo
            //prendo gli utenti che seguono il luogo
            $query = "SELECT IdUtente FROM LuogoSeguito WHERE IdLuogo = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idLuogo);
            $stmt->execute();
            $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            //per ogni utente aggiungo una notifica
            foreach ($idUtenti as $idUtente) {
                $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                $stmt = $this->db->prepare($query);
                $messaggio = "E' stato aggiunto l'evento " . $titolo . " ad un luogo che segui.";
                $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                $stmt->execute();
            }
        }

        return $idEvento;
    }

    public function aggiungiNotifica($idEvento){
        //aggiungi notifica per gli utenti che seguono gli artisti
        //prendo tutti gli artisti dell'evento
        $result = "";
        $query = "SELECT IdArtista FROM ArtistaEvento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $idArtisti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        //per ogni artista mi trovo gli utenti che lo seguono
        foreach ($idArtisti as $idArtista) {
            $query = "SELECT IdUtente FROM ArtistaSeguito WHERE IdArtista = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $idArtista["IdArtista"]);
            $stmt->execute();
            $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            //per ogni utente aggiungo una notifica
            foreach ($idUtenti as $idUtente) {
                $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                $stmt = $this->db->prepare($query);
                $messaggio = "E' stato aggiunto un evento ad un artista che segui.";
                $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                $result = $stmt->execute();
            }
        }
    }

    public function ricercaArtisti($nomeArtista){
        $param = "%{$nomeArtista}%";
        $query = 'SELECT * FROM Artista WHERE Nome LIKE ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function ricercaLuoghi($nomeLuogo){
        $param = "%{$nomeLuogo}%";
        $query = 'SELECT * FROM Luogo WHERE Nome LIKE ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function ricercaEventi($nomeEvento){
        $param = "%{$nomeEvento}%";
        $query = 'SELECT * FROM Evento WHERE Titolo LIKE ? && DataInizio >= CURDATE()';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $param);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotReadNotify($IdUtente){
        $query = 'SELECT * FROM Notifica WHERE IdUtente = ? AND Letto = 0 AND Visualizzato = 0 ORDER BY IdNotifica LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdUtente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateNotify($IdNotify){
        $query = "UPDATE Notifica SET Visualizzato = 1 WHERE IdNotifica = ?";        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdNotify);
        $stmt->execute();
    }

    public function aggiungiReportEvento($idEvento, $idUtente, $descrizioneReport){
        $query = "INSERT INTO Segnalazione (IdUtente, IdEvento, Descrizione) VALUE (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iis',$idUtente, $idEvento, $descrizioneReport);
        $result = $stmt->execute();

        $query = "SELECT IdArtista FROM ArtistaEvento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $idArtisti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        //per ogni artista mi trovo gli utenti che lo seguono
        foreach ($idArtisti as $idArtista) {
            $query = "SELECT IdUtente FROM Utente WHERE IdTipoUtente = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $idUtenti = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            //per ogni utente aggiungo una notifica
            foreach ($idUtenti as $idUtente) {
                $query = "INSERT INTO Notifica (IdUtente, Testo, Data, Letto) VALUE (?, ?, CURDATE(), 0)";
                $stmt = $this->db->prepare($query);
                $messaggio = "E' stata fatta una segnalazione";
                $stmt->bind_param('is', $idUtente["IdUtente"], $messaggio);
                $stmt->execute();
            }
        }
        return $result;
    }
}
?>