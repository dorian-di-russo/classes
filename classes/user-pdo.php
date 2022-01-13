<?php


class UserPdo
{

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct(
        $dbhost = "localhost",
        $dbname = "classes",
        $username = "root",
        $password    = "",
        $login = NULL,
        $email = NULL,
        $firstname = NULL,
        $lastname = NULL
    ) {

        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname; {

            try {

                $this->connection = new PDO("mysql:host={$dbhost};dbname={$dbname};", $username, $password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
    public function RegisterPdo($login, $password, $email, $firstname, $lastname)
    {

        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        try {
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->connection->prepare("INSERT INTO utilisateurs (login, password,email,firstname,lastname) VALUES (:login,:password,:email,:firstname,:lastname)");

            $stmt->bindparam(":login", $login);
            $stmt->bindparam(":password", $passwordhash);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":firstname", $firstname);
            $stmt->bindparam(":lastname", $lastname);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function Connectpdo($login, $password)
    {

        $this->login = $login;
        $this->password = $password;


        try {
            $stmt = $this->connection->prepare("SELECT * FROM utilisateurs WHERE login=:login LIMIT 1");
            $stmt->execute(array('login' => $login));
            $userRow = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                if (password_verify($password, $userRow['password'])) {
                    $_SESSION['login'] = $userRow['login'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function UpdatePdo($login, $password, $email, $firstname, $lastname)
    {


        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;


        try {

            $stmt = $this->connection->prepare("UPDATE utilisateurs SET `login` = :login, `password` = :password, `email` = :email, `firstname` = :firstname,`lastname` = :lastname  WHERE login= :login");

            $stmt->bindparam(":login", $login);
            $stmt->bindparam(":password", $password);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":firstname", $firstname);
            $stmt->bindparam(":lastname", $lastname);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function logoutPdo()
    {

        session_destroy();
        unset($_SESSION['login']);
        return true;
    }



    public function isLogPdo()
    {

        if (isset($_SESSION['login'])) {
            echo 'Bonjour' . $this->login;
            return true;
        } else {
            echo 'aucune session active';
            return false;
        }
    }

    public function DelatePdo()
    {
                        
                        try {

                        $stmt = $this->connection->prepare("DELETE FROM utilisateurs WHERE login = :login");

                        $stmt->bindValue(':login',$this->login);

                        $stmt->execute();

                        return $stmt;

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
    }

    public function GetLoginPdo() {
        return $this->login;
    }

    public function GetFirstNamePdo() {
        return $this->firstname;
    }

    public function getLastNamePdo () {
        return $this->lastname;
    }

    public function GetEmailPdo () {

        

        return $this->email;
    }


    public function  GetAllInfosPdo()
    {
       
        return $this->login.$this->email.$this->firstname.$this->lastname;
    }


}
