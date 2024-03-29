/* eslint-disable no-undef */
'use strict';
$(function() {
/**
 * jQuery functionality
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 January/September 2019
 *          1.0.1 Linting, code style improvement
 */

    // Initial movie load
    FLoadMovies();

    // Movie search
    // Added September 2019
    $('#txtMovieSearch').on('input', function() {
        $('#lstMovies').empty();
        $.ajax({
            url: 'src/main.php',
            type: 'POST',
            data: {
                action: 'search',
                movie_search_text: $('#txtMovieSearch').val()
            },            
            success: function(data){
                const MOVIE_ID = 0;
                const NAME = 1;
                const acMovies = JSON.parse(data);
                $.each(acMovies, function(index, value) {
                    $('#lstMovies').append(new Option(value[NAME], value[MOVIE_ID]));
                });
            }
        });
    });

    // Button enabling    
    $('#lstMovies').on('change', function() {
        if($(this).val() === null) {
            $('#btnModify').prop('disabled', 'disabled');
            $('#btnDelete').prop('disabled', 'disabled');
        } else {
            $('#btnModify').prop('disabled', '');
            $('#btnDelete').prop('disabled', '');
        }
    });

    // Modal button enabling
    $('#txtMovie').on('change', function() {
        if($(this).val() === '')
            $('#btnOk').prop('disabled', 'disabled');
        else
            $('#btnOk').prop('disabled', '');
    });

    // Add button clicked
    $('#btnAdd').click(function() {
        $('#txtMovie').val('');
        $('#modalCaption').text('Add Movie');

    });

    // Modify button clicked
    $('#btnModify').click(function() {
        $('#txtMovie').val($('#lstMovies option:selected').text());
        $('#modalCaption').text('Modify Movie');
    });

    // Delete button clicked
    $('#btnDelete').click(function() {
        if (window.confirm('The movie will be deleted. Are you sure?'))
            $.ajax({
                url: 'src/main.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    movie_id: $('#lstMovies').val()
                },
                success: function(data){
                    const RES_OK = 1;                    
                    const result = JSON.parse(data);

                    if (result === RES_OK)
                        FLoadMovies();
                    else
                        alert('The movie could not be deleted');
                }
            });
    });

    // Ok button clicked
    $('#btnOk').click(function() {
        let data;
        if ($('#modalCaption').text() === 'Add Movie'){      // Add movie
            data = {
                action: 'add',
                movie_name: $('#txtMovie').val()
            };

            $.post('src/main.php', data, function(){
                $('#btnCancel').click();
                FLoadMovies();
            });
        } else {                                            // Modify movie
            data = {
                action: 'modify',
                movie_id: $('#lstMovies').val(),
                movie_name: $('#txtMovie').val()
            };

            $.post('src/main.php', data, function(){
                $('#btnCancel').click();
                FLoadMovies();
                $('#lstMovies').trigger('change');
            });
        }
    });
    
});

/**
 * Loads all the movies in the listBox in alphabetic order
 */
function FLoadMovies() {
    $('#lstMovies').empty();
    $.ajax({
        url: 'src/main.php',
        type: 'POST',
        data: {action: 'load'},
        success: function(data){
            const MOVIE_ID = 0;
            const NAME = 1;
            const acMovies = JSON.parse(data);
            $.each(acMovies, function(index, value) {
                $('#lstMovies').append(new Option(value[NAME], value[MOVIE_ID]));
            });
        }
    });
}