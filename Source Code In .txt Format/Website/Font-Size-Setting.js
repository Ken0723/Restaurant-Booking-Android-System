$(document).ready(function () {

    $("#small-font").click(function () {
        $('body').find("*").not(".font-setting").not("input").css("font-size", '17px');
        //$('body').find("#main a").css("font-size", '30px');
    });

    $("#medium-font").click(function () {
        $('body').find("*").not(".font-setting").not("input").css("font-size", '22.5px');
        //$('body').find("#main a").css("font-size", '30px');
    });

    $("#large-font").click(function () {
        $('body').find("*").not(".font-setting").not("input").css("font-size", '26px');
        //$('body').find("#main a").css("font-size", '30px');
    });

});