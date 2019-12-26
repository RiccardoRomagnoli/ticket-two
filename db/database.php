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
        $stmt = $this->db->prepare("SELECT *, TipoUtente.Nome AS TipoUtente, Utente.Nome AS Nome FROM Utente INNER JOIN TipoUtente ON Utente.IdTipoUtente = TipoUtente.IdTipoUtente WHERE ? = Mail AND ? = Password");
        $stmt->bind_param('ss',$mail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id){
        $stmt = $this->db->prepare("SELECT *, TipoUtente.Nome AS TipoUtente, Utente.Nome AS Nome FROM Utente INNER JOIN TipoUtente ON Utente.IdTipoUtente = TipoUtente.IdTipoUtente WHERE IdUtente = ?");
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

    public function getArtistById($id){
        $stmt = $this->db->prepare("SELECT * FROM Artista WHERE IdArtista = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdArtist($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.Locandina as Locandina, Evento.DataInizio as DataInizio, Evento.DataFine as DataFine, Citta.Nome as NomeCitta
            FROM ArtistaEvento, Evento, Luogo, Citta
            WHERE Evento.IdEvento = ArtistaEvento.IdEvento and Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta and ArtistaEvento.IdArtista = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventByIdEvento($id){
        $stmt = $this->db->prepare(
            "SELECT Evento.Titolo as TitoloEvento, Evento.Descrizione as EventoDescrizione,
                 Evento.Locandina as Locandina, Evento.DataInizio as DataInizio,
                 Evento.DataFine as DataFine, Citta.Nome as NomeCitta, Luogo.Nome as NomeLuogo
            FROM Evento, Luogo, Citta
            WHERE Evento.IdEvento = ? and Evento.IdLuogo = Luogo.IdLuogo and Luogo.IdCitta = Citta.IdCitta");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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
                Biglietto.DataInizio as DataInizioBiglietto, Biglietto.DataFine as DataFineBiglietto, TipoBiglietto.Nome as NomeBiglietto 
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
        return $result = $stmt->get_result();;
    }

    public function removeInterest($IdInterest, $IdUser){
        $query = "DELETE FROM CategoriaSeguita WHERE IdCategoria = ? AND IdUtente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$IdInterest, $IdUser);
        $stmt->execute();
        return $result = $stmt->get_result();;
    }

    public function insertPayment($Titolare, $Data, $Numero, $IdUtente){
        $query = "INSERT INTO MetodoPagamento (IdUtente, NumeroCarta, DataScadenza, Titolare) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isss', $IdUtente, $Numero, $Data, $Titolare);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    //TO UPDATE

    public function getRandomPosts($n){
        $stmt = $this->db->prepare("SELECT idarticolo, titoloarticolo, imgarticolo FROM articolo ORDER BY RAND() LIMIT ?");
        $stmt->bind_param('i',$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPosts($n=-1){
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo, anteprimaarticolo, dataarticolo, nome FROM articolo, autore WHERE autore=idautore ORDER BY dataarticolo DESC";
        if($n > 0){
            $query .= " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if($n > 0){
            $stmt->bind_param('i',$n);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertArticle($titoloarticolo, $testoarticolo, $anteprimaarticolo, $dataarticolo, $imgarticolo, $autore){
        $query = "INSERT INTO articolo (titoloarticolo, testoarticolo, anteprimaarticolo, dataarticolo, imgarticolo, autore) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssssi',$titoloarticolo, $testoarticolo, $anteprimaarticolo, $dataarticolo, $imgarticolo, $autore);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    public function updateArticleOfAuthor($idarticolo, $titoloarticolo, $testoarticolo, $anteprimaarticolo, $imgarticolo, $autore){
        $query = "UPDATE articolo SET titoloarticolo = ?, testoarticolo = ?, anteprimaarticolo = ?, imgarticolo = ? WHERE idarticolo = ? AND autore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssii',$titoloarticolo, $testoarticolo, $anteprimaarticolo, $imgarticolo, $idarticolo, $autore);
        
        return $stmt->execute();
    }

    public function deleteArticleOfAuthor($idarticolo, $autore){
        $query = "DELETE FROM articolo WHERE idarticolo = ? AND autore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$idarticolo, $autore);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }
}
?>