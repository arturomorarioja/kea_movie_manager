<?php
/**
 * Encapsulates a connection to the database 
 * 
 * @author Arturo Mora-Rioja
 * @date   September 2019
 */
    class DB {

        /**
         * Opens a connection to the database
         * 
         * @returns a connection object
         */
        public function connect() {
            $cServer = 'localhost';
            $cDB = 'movies';
            $cUser = 'root';
            $cPwd = '';

            $cDSN = 'mysql:host=' . $cServer . ';dbname=' . $cDB . ';charset=utf8';
            $cOptions = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $cnDB = @new PDO($cDSN, $cUser, $cPwd, $cOptions); 
            } catch (\PDOException $oException) {
                echo 'Connection unsuccessful';
                die('Connection unsuccessful: ' . $cnDB->connect_error());
                exit();
            }
            
            return($cnDB);   
        }

        /**
         * Closes a connection to the database
         * 
         * @param the connection object to disconnect
         */
        public function disconnect($pcnDB) {
            $pcnDB = null;
        }
    }
?>