$(document).ready(function(){

    //NO form resubmision
    if ( window.history.replaceState ) {  
        window.history.replaceState( null, null, window.location.href );
    }

    //navbar hamburger menu
    $(".nav-menu").click(function(){
        if($(".nav-links").css("display") === "none") {
            $(".nav-links").css('display', 'block');
            $(".nav").addClass("active");
            $(".main-container").addClass("active");
            $("footer").addClass("active");
            $(".nav-menu i").addClass("gg-close");
            $(".nav-menu i").removeClass("gg-menu");
        } else {
            $(".nav-links").css('display', 'none');
            $(".nav").removeClass("active");
            $(".main-container").removeClass("active");
            $("footer").removeClass("active");
            $(".nav-menu i").addClass("gg-menu");
            $(".nav-menu i").removeClass("gg-close");
        }
    })

    //if no files is selected we will print nothing selected
    if(!$("#import-csv").val()){
        $(".selected-file").html("Nothing selected")
    }

    //Printing the name of the file if we selected one
    $("#import-csv").change(function(){
        console.log()
        $(".selected-file").html($("#import-csv").val().split('\\').pop())
    })

    
    
})