<?php
/**
 * Movie class
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 January/September 2019
 */
require_once("connection.php");

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

            $cQuery = 'SELECT nMovieID, cName FROM movies ORDER BY cName';

            $stmt = $con->query($cQuery);
            while($row = $stmt->fetch())
                $results[] = [$row["nMovieID"], $row["cName"]];

            $stmt = null;
            $db->disconnect($con);
            
            return($results);

        } else 
            return false;
    }

    /**
     * Retrieves the movies whose name matches a certain text
     * 
     * @param text upon which to execute the search
     * @return matching movie fields (ID, movie name) ordered by movie name
     */
    function search($pcSearchText) {
        $db = new DB();
        $con = $db->connect();
        if ($con) {
            $results = array();

            $cQuery = 'SELECT nMovieID, cName ' . 
                'FROM movies ' .
                'WHERE cName LIKE ? ' .
                'ORDER BY cName';

            $stmt = $con->prepare($cQuery);
            $stmt->execute(['%' . $pcSearchText . '%']);
            while($row = $stmt->fetch())
                $results[] = [$row["nMovieID"], $row["cName"]];

            $stmt = null;
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
    function add($pcMovieName) {
        $db = new DB();
        $con = $db->connect();
        if ($con) {
            $cQuery = 'INSERT INTO ' .
                'movies ' .
                    '(cName) ' .
                'VALUES (?)';

            $stmt = $con->prepare($cQuery);
            $ok = $stmt->execute([$pcMovieName]);

            $stmt = null;                
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
    function update($pnMovieID, $pcMovieName) {
        $db = new DB();
        $con = $db->connect();
        if ($con) {
            $cQuery = 'UPDATE ' .
                'movies ' .
                'SET ' .
                'cName = ? ' .
                'WHERE ' .
                'nMovieID = ?';

            $stmt = $con->prepare($cQuery);
            $ok = $stmt->execute([$pcMovieName, $pnMovieID]);  

            $stmt = null;                
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
    function delete($pnMovieID) {
        $db = new DB();
        $con = $db->connect();
        if ($con) {
            $cQuery = 'DELETE FROM ' .
                'movies ' .
                'WHERE ' .
                'nMovieID = ?';

            $stmt = $con->prepare($cQuery);
            $ok = $stmt->execute([$pnMovieID]);

            $stmt = null;                
            $db->disconnect($con);
            
            return ($ok);

        } else 
            return false;
    }

}