
    var name = "";
    var comment = "";

    function addComment() {
        var name = document.getElementById("name").value;
        var comment = document.getElementById("comment").value;

        var name2 = document.getElementById("name");

        if (name == "" || comment == "") {
            if (name == "") {
                document.getElementById("name").value = "Please enter your name";
                document.getElementById("name").style.color = "red";
            }
            if (comment == "") {
                document.getElementById("comment").value = "Please enter your comment";
                document.getElementById("comment").style.color = "red";
            }
        } else if (
            name == "Please enter your name" ||
            comment == "Please enter your comment"
        ) {
            name2.style.color = "black";
        } else {
            var d = new Date($.now());
            var now = moment().format("d/M/Y h:mm:ss A");
            name.bold();
            var radioValue = $("input[name='rate']:checked").val();

            var rating = "";
            var i = 0;
            for (i = 0; i < radioValue; i++) {
                rating += '<span class="fa fa-star checked"></span>';
            }

            for (var j = 5 - i; j > 0; j--) {
                rating += '<span class="fa fa-star"></span>';
            }
            var nameResult = $("<td class='nameTag'></td>").html(
                name + " says &nbsp;&nbsp;&nbsp;" + rating
            );
            var commentResult = $("<td></td>").text(now);

            var newRow = $("<tr></tr>").append(nameResult, commentResult);

            var comResult = $("<td colspan='2'></td>").text(comment);

            var commentRow = $("<tr></tr>").append(comResult);
            $("#resultBody").append(newRow, commentRow);
            $(".nameTag").css("font-weight", "bold");
        }

        // $("#commentTable").append("<tr><td class='dateTable'>"+d.toDateString()+"</td><td class='comName'>"+name+"</td></tr><tr><td class='comCom'>"+comment+"</td></tr>");

        // $("#commentArea").append("<div class='panel-heading'>"+name+"</div>");

        // var txt2 = $("<div class='panel-heading'></div>").text(name);
        //$("#resultsPanel").append("<tr><td>"+name+"</td><td style='text-align:'right''>"+comment+"</td></tr>");
        //var txt3 = $("<div class='panel-body'></div>").text(comment);
        //var txt4 = $("<div class='panel-footer'>Panel Footer</div>").text(d.toDateString())
        //$("#results").append(txt2, txt3, txt4);
    }
