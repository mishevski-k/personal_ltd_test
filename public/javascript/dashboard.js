$(document).ready(function(){
    if ( window.history.replaceState ) {  
        window.history.replaceState( null, null, window.location.href );
    }
    
    let page_number = 0;

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