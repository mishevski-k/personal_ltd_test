$(document).ready(function(){
    //No resubmision
    if ( window.history.replaceState ) {  
        window.history.replaceState( null, null, window.location.href );
    }
    
    //page number for our home page
    let page_number = 0;

        //ajax call to get and display calls data in our calls-container
        $.ajax({
            url: "admin/calls",
            method: "POST",
            data: {
                page_number: page_number,
            },
            success:function(data){
                $(".calls-container").html(data);
            }
        })
})