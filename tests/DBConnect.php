<?php
    class DBConnect
    {

        // Local: "localhost", "CDD", "root", ""
        // Online: "cdd.ens.fr", "cdd", "usercdd", "mdptac2019"
        private $server = "mysql:host=cdd.ens.fr;dbname=cdd";

        private $user = "usercdd";

        private $pass = "mdptac2019";

        private $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        protected $con;

        /* Function for opening connection */
        public function openConnection()
        {
            try
            {
                $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
                return $this->con;
            }
            catch (PDOException $e) {
                echo "There is some connection issue: " . $e->getMessage();
            }
        }

        /* Function for closing connection */
        public function closeConnection()
        {
            $this->con = null;
        }
    }
?>