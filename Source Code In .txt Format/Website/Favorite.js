$(document).ready(function () {
    var $ul = $('#favorite-links');
    var $title = $('#title');
    var $url = $('#url');

    //add new item



    /*$('.add-favorite-btn').click(function () {
     
     $('#favorite-links').append('<li><a href="' + $(this).siblings("a").attr("href") + '">' + $(this).siblings("a").html() + '</a><button class="removebtn">x</button></li>');
     $(this).toggleClass('add-favorite-btn remove-favorite-btn').html('&hearts;');
     
     });
     
     $('.remove-favorite-btn').click(function () {
     
     $('#favorite-links').append('<li><a href="' + $(this).siblings("a").attr("href") + '">' + $(this).siblings("a").html() + '</a><button class="removebtn">x</button></li>');
     $(this).toggleClass('add-favorite-btn remove-favorite-btn').html('&hearts;');
     
     });*/

    $('.add-favorite-btn').click(function () {

        $('#favorite-links').append('<li><a href="' + $(this).siblings("a").attr("href") + '">' + $(this).siblings("a").html() + '</a><button class="removebtn">x</button></li>');
        $(this).hide();

    });

    // add nwe item
    $('#add').click(function () {

        //add new item
        $('#favorite-links').append('<li><a href="' + $url.val() + '">' + $title.val() + '</a><button class="removebtn">x</button></li>');

        //reset form
        $title.val("");
        $url.val("http://");
        $("#add-link-form").slideToggle("100");

    });

    //remove item


    $("#favorite-links").on('click', '.removebtn', function () {
        $(this).parent().remove();

        var value = $(this).siblings('a').html();
        $(".title-name a").filter(':contains(' + value + ')').siblings('.add-favorite-btn').show();
        //alert($(".title-name a").filter(':contains(' + value + ')').siblings('.add-favorite-btn').parent().parent().parent().html());
    });

    //form toggle
    $("#new-link-button").click(function () {
        $("#add-link-form").slideToggle("100");
    });

    $('#showbox-btn').hide();
    $('#hidebox-btn').click(function () {

        $('#showbox-btn').show();
        $('#aside').toggle();

    });

    $('#showbox-btn').click(function () {

        $('#showbox-btn').hide();
        $('#aside').toggle();

    });

});