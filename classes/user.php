<?php






class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct($login = null, $email = null, $firstname = null, $lastname = null, $id = null)
    {
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->id = $id;
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        $connect = mysqli_connect('localhost', 'root', '', 'classes');
        $request = "INSERT INTO utilisateurs(login,password,email,firstname,lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')";

        $query = mysqli_query($connect, $request);
    }


    public function connect($login, $password)

    {
        $this->_login = $login;
        $this->_password = $password;


        $connect = mysqli_connect('localhost', 'root', '', 'classes');
        $request = "SELECT * FROM utilisateurs";

        $query = mysqli_query($connect, $request);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);




        for ($i = 0; isset($result[$i]); $i++) {
            $id = $result[$i]['id'];
            $passwordcheck = $result[$i]['password'];
            $logincheck = $result[$i]['login'];


            if ($login == $logincheck && $password == $passwordcheck) {
                $_SESSION['login'] = $id;
                var_dump($_SESSION['login']);
                echo "Vous êtes connecté " . '<br/>';
            }
        }
        if ($passwordcheck == FALSE) {
            echo "Erreur";
        }
    }


    public function disconnect()
    {

        $connect = mysqli_connect('localhost', 'root', '', 'classes');
        $request = "SELECT * FROM utilisateurs";
        mysqli_close($connect);
        session_destroy();
        echo "Vous êtes déconnecté";
    }

    // public function getbyid($id) {
    //     $connect = mysqli_connect('localhost', 'root', '', 'classes');
    //     $query = "SELECT * FROM utilisateurs WHERE id=$id";
    //     $data = mysqli_query($connect,$query);
    //     $rec = mysqli_fetch_object($data);
    //     var_dump($query);

    // }




    public function delate()
    {


        $connect = mysqli_connect('localhost', 'root', '', 'classes');

        $delete = "DELETE FROM utilisateurs WHERE login = utilisateurs.login LIMIT 1"; // changer id pour supprimer 
        $rsDelate = $connect->query($delete);
        echo "Deleted rows :" . $connect->affected_rows;
        $connect->close();
    }
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;


        $connect = mysqli_connect('localhost', 'root', '', 'classes');
        $request = "UPDATE utilisateurs SET login = '$login' , password = '$password', email = '$email', firstname = '$firstname' , lastname = '$lastname' WHERE id = 98   ";
        $query = $connect->query($request);
    }




    public function isConnected()
    {




        if (isset($_SESSION['login']) == true) {

            echo 'session active';
        } else {

            if (isset($_SESSION['login']) == false) {

                echo 'session non active';
            }
        }
    }
    public function  GetAllInfos()
    {
       
        return $this->login.$this->email.$this->firstname.$this->lastname;
    }



    public function getLogin()
    {

        return $this->login;
    }

    public function getEmail()
    {

        return $this->email;
    }

    public function getFirstname()
    {

        return $this->firstname;
    }

    public function getLastname()
    {

        return $this->lastname;
    }


    //    ****
}
