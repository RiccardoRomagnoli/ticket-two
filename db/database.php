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
            FROM Evento, CategoriaEvento, Luogo, Citta
            WHERE Evento.IdLuogo = Luogo.IdLuogo 
                and Luogo.IdCitta = Citta.IdCitta
                and Evento.DataInizio >= CURDATE()
                and CategoriaEvento.IdCategoria IN 
                (SELECT IdCategoria
                FROM CategoriaSeguita
                WHERE IdUtente = ?)
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
            and Evento.IdUtente IN (" . $idEventsMatchingMyCategoriesExcludingMyEvents . ") 
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
                Sezione.IdEvento = ? AND Acquisto.IdUtente = ?");
        $stmt->bind_param('ii', $idEvent, $idUser);
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
            "SELECT Categoria.Nome
            FROM Evento INNER JOIN CategoriaEvento ON Evento.IdEvento = CategoriaEvento.IdEvento 
                INNER JOIN Categoria ON Categoria.IdCategoria = CategoriaEvento.IdCategoria 
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
        
        return $stmt->execute();
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

        return $result->fetch_all(MYSQLI_ASSOC);
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
}
?>