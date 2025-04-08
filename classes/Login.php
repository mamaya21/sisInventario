<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            //$servidor_l= "Driver={SQL Server};Server=".DB_HOST.";Database=".DB_NAME.";Integrated Security=SSPI;Persist Security Info=False;";
            //$db_connection = odbc_connect($servidor_l,DB_USER,DB_PASS);

            require_once('config/conexion.php'); // Incluye tu conexión
            $db_connection = $con;

            if (!$db_connection) {
                $this->errors[] = "Problema de conexión a la base de datos.";
                return;
            }


            // change character set to utf8 and check it
            /*if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }*/

            // if no connection errors (= working database connection)
            /*if (!$this->db_connection->connect_errno) {*/

                // escape the POST stuff
                //$user_name = $this->db_connection->real_escape_string($_POST['user_name']);
                $user_name=$_POST['user_name'];
                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT id_usuario, usuario, pass, facilidad 
                        FROM usuarios
                        WHERE usuario = '" . $user_name . "' 
                        LIMIT 1;";

                $result = mysqli_query($db_connection, $sql);

                if ($result && mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    $decoded_pass = base64_decode(base64_decode($row['pass']));
                
                    if ($_POST['user_password'] === $decoded_pass) {
                        $_SESSION['user_id'] = $row['id_usuario'];
                        $_SESSION['user_name'] = $row['usuario'];
                        $_SESSION['facilidad'] = $row['facilidad'];
                        $_SESSION['user_email'] = $row['email'];
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "Usuario y/o contraseña no coinciden.";
                    }
                } else {
                    $this->errors[] = "Usuario y/o contraseña no coinciden.";
                }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "Has sido desconectado.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
