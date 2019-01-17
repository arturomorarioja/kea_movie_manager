<?php
/**
 * Movie class
 * 
 * @author Arturo Mora-Rioja
 * @date   January 2019
 */
include("connection.php");

    class Movie {
        /**
         * Retrieves movie information
         * 
         * @return all movie fields (ID, movie name) ordered by movie name
         */
        function list() {
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $results = array();

                $sql = "SELECT nMovieID, cName FROM movies ORDER BY cName";

                $query = $con->query($sql);
                while($row = $query->fetch_row())
                    $results[] = $row;

                $query->close();
                $db->disconnect($con);
                
                return($results);

            } else 
                return false;
        }

        /**
         * Inserts a new movie
         * 
         * @param name of the new movie
         * @return true if the insertion was correct, false if there was an error
         */
        function add($movieName) {
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $query = "INSERT INTO " .
                    "movies " .
                    "(cName) " .
                    "VALUES (" .
                    "'" . $movieName . "'" .
                    ")";

                $ok = $con->query($query);
                $db->disconnect($con);
                
                return ($ok);

            } else 
                return false;
        }

        /**
         * Updates the name of a movie
         * 
         * @param id of the movie to update
         * @param new name of the movie
         * @return true if the update was correct, false if there was an error
         */
        function update($movieID, $movieName) {
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $query = "UPDATE " .
                    "movies " .
                    "SET " .
                    "cName = '" . $movieName . "'" .
                    "WHERE " .
                    "nMovieID = " . $movieID;

                $ok = $con->query($query);
                $db->disconnect($con);
                
                return ($ok);

            } else 
                return false;
        }

        /**
         * Deletes a movie
         * 
         * @param id of the movie to delete
         * @return true if the deletion was correct, false if there was an error
         */
        function delete($movieID) {
            $db = new DB();
            $con = $db->connect();
            if ($con) {
                $query = "DELETE FROM " .
                    "movies " .
                    "WHERE " .
                    "nMovieID = " . $movieID;

                $ok = $con->query($query);
                $db->disconnect($con);
                
                return ($ok);

            } else 
                return false;
        }

    }
?>