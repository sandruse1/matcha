$(document).ready(function(){
    $("#edit-info").on("click",function(){

        $(".info-section").removeClass("no-edit-forms");
        $(this).hide();
        $("#cancel-info").removeClass("hide");
        $("#accountsetSubmit").removeClass("hide");
    });
    $("#cancel-info").on("click",function(){
        window.location.reload();
    });
    $(".upload-image").dropzone();
});


