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
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta
            WHERE Evento.IdEvento = ? and Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta");
        $stmt->bind_param('i', $id);
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
                Biglietto.IdBiglietto as IdBiglietto
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
                                                  INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdBiglietto
                                                  INNER JOIN Evento On Evento.IdEvento = Sezione.IdEvento
                                                  INNER JOIN TipoBiglietto On Biglietto.IdTipoBiglietto = TipoBiglietto.IdTipoBiglietto
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
                                                  INNER JOIN Sezione ON Sezione.IdSezione = Biglietto.IdBiglietto
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
}
?>