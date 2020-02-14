$(document).ready(function(){
    $("#toggle_button").button({
        icons: {
                primary: "ui-icon-plus"
            },
        text : false
    });
    $("#toggle_button").click(function(){
        if($(this).is(".showcontrol"))
        {
            $(this).parent("div").children(":not(#toggle_button)").hide();
            $(this).parent("div").animate({"width":"30px"});
            $(this).removeClass("showcontrol");
        }
        else 
        {
            
            $(this).parent("div").animate({"width":"100%"});
            setTimeout($(this).parent("div").children(":not(#toggle_button)").show(),2000);
            $(this).addClass("showcontrol");
        }
    });
});