$(document).ready(function() {
/**
 * jQuery functionality
 * 
 * @author Arturo Mora-Rioja
 * @date   January 2019
 */

    // Initial movie load
    FLoadMovies();

    // Button enabling    
    $("#lstMovies").on("change", function() {
        if($(this).val() == null) {
            $("#btnModify").prop("disabled", "disabled");
            $("#btnDelete").prop("disabled", "disabled");
        } else {
            $("#btnModify").prop("disabled", "");
            $("#btnDelete").prop("disabled", "");
        }
    });

    // Modal button enabling
    $("#txtMovie").on("change", function() {
        if($(this).val() == "")
            $("#btnOk").prop("disabled", "disabled");
        else
            $("#btnOk").prop("disabled", "");
    });

    // Add button clicked
    $("#btnAdd").click(function() {
        $("#txtMovie").val("");
        $("#modalCaption").text("Add Movie");

    });

    // Modify button clicked
    $("#btnModify").click(function() {
        $("#txtMovie").val($("#lstMovies option:selected").text());
        $("#modalCaption").text("Modify Movie");
    });

    // Delete button clicked
    $("#btnDelete").click(function() {
        if (window.confirm("The movie will be deleted. Are you sure?"))
            $.ajax({
                url: "src/main.php",
                type: "POST",
                data: {
                    action: "delete",
                    movie_id: $("#lstMovies").val()
                },
                success: function(data){
                    const RES_OK = 1;                    
                    var result = JSON.parse(data);

                    if (result == RES_OK)
                        FLoadMovies();
                    else
                        alert("The movie could not be deleted");
                }
            });
    });

    // Ok button clicked
    $("#btnOk").click(function() {
        if ($("#modalCaption").text() == "Add Movie"){      // Add movie
            data = {
                action: "add",
                movie_name: $("#txtMovie").val()
            };

            $.post("src/main.php", data, function(d){
                $("#btnCancel").click();
                FLoadMovies();
            });
        } else {                                            // Modify movie
            data = {
                action: "modify",
                movie_id: $("#lstMovies").val(),
                movie_name: $("#txtMovie").val()
            };

            $.post("src/main.php", data, function(d){
                $("#btnCancel").click();
                FLoadMovies();
                $("#lstMovies").trigger("change");
            });
        }
    });
    
});

/**
 * Loads all the movies in the listBox in alphabetic order
 */
function FLoadMovies() {
    $("#lstMovies").empty();
    $.ajax({
        url: "src/main.php",
        type: "POST",
        data: {action: "load"},
        success: function(data){
            var MOVIE_ID = 0;
            var NAME = 1;
            var acMovies = JSON.parse(data);

            $.each(acMovies, function(index, value) {
                $("#lstMovies").append(new Option(value[NAME], value[MOVIE_ID]));
            });
        }
    });
}