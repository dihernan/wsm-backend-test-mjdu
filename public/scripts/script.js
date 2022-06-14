$(document).ready(function(){
    $("#btn_query").click(function(){
        checkAccountID($("#account_id").val());
    });
});

function checkAccountID(id){
    if (id == ""){
        $(".message_info").html("The field Account Id is empty.");
        $(".list_items").html("");
        return;
    } else {
        location.href="accounts/"+id;
    }
}
