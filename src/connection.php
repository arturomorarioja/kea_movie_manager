<?php
/**
 * Encapsulates a connection to the database 
 * 
 * @author Arturo Mora-Rioja
 * @date   January 2019
 */
    class DB {

        /**
         * Opens a connection to the database
         * 
         * @returns a connection object
         */
        public function connect() {
            $cServer = "localhost";
            $cDB = "movies";
            $cUser = "root";
            $cPwd = "";
            $cnDB = @new mysqli($cServer, $cUser, $cPwd, $cDB); 
            if ($cnDB->connect_error) {
                die("Connection unsuccessful: " . $cnDB->connect_error());
                exit();
            } else 
                return($cnDB);   
        }

        /**
         * Closes a connection to the database
         * 
         * @param the connection object to disconnect
         */
        public function disconnect($pcnDB) {
            return(mysqli_close($pcnDB));
        }
    }
?>