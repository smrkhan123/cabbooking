function loc() {
    var x = document.getElementById("pickup").value;
    $("#drop option[value='" + x + "']").attr("disabled", "disabled").siblings().removeAttr("disabled");
    $("#calculatedFare").html("Calculate Fare");
}
function droploc() {
    var x = document.getElementById("drop").value;
    $("#pickup option[value='" + x + "']").attr("disabled", "disabled").siblings().removeAttr("disabled");
    $("#calculatedFare").html("Calculate Fare");
}
function cabType() {
    $("#calculatedFare").html("Calculate Fare");
    var x = document.getElementById("cab_type").value;
    if (x == "cedmicro") {
        $("#luggage").val("");
        $("#luggage").prop('disabled', true);
    } else {
        $("#luggage").prop('disabled', false);
    }
}
function farecalc() {
    var pckup = $("#pickup").val();
    var drp = $("#drop").val();
    var cb = $("#cab_type").val();
    var lug = $("#luggage").val();
    if (pckup == "" || drp == "" || cb == "") {
        alert("Please fill the form compeletely");
    } else {
        $.ajax({
            url: "ajax.php",
            method: "POST",
            data: { pickup: pckup, drop: drp, cab: cb, luggage: lug },
            dataType: "json"
        }).done(function (msg) {
            $("#calculatedFare").html("<strong>Calculated Fare: "+ msg[0] +"</strong>");
            $("#buttonfare").val(msg[0]);
            $("#distanceinput").val(msg[1]);
            $(".subButton").css("display", "block");
        });
    }
}
$("#luggage").keyup(function(){
    var w =$("#luggage").val();
    if(isNaN(w) == true) {
        alert("Interger Value Needed");
        $("#luggage").val("");
    }
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
  $("#wrap").toggleClass("toggled");
  });

