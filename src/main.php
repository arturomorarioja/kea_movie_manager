<?php
/**
 * Main backend API
 * 
 * @author Arturo Mora-Rioja
 * @date   January 2019
 */
include("movie.php");

    $movie = new Movie();

    switch($_POST['action']) {
        case 'load':
            echo json_encode($movie->list());
            break;
        case 'add':
            echo json_encode($movie->add($_POST['movie_name']));
            break;
        case 'modify':
            echo json_encode($movie->update($_POST['movie_id'], $_POST['movie_name']));
            break;
        case 'delete':
            echo json_encode($movie->delete($_POST['movie_id']));
            break;
    }
?>