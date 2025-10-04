
function qrUrl() {
document.getElementById("text").value = window.location.href;
if (window.location.href.split("?gen=")[1]) {
	var url = decodeURI(window.location.href.split("?gen=")[1]);

	document.getElementById("text").value = url;
	makeCode();
	} else {
		document.getElementById("text").value = window.location.href;
		makeCode();
	}
}

var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 240,
	height : 240
});

function makeCode () {		
	var elText = document.getElementById("text");
	if (!elText.value) {
		document.getElementById("text").value = "Insert text here";
		elText.focus();
		return;
	}
	
	qrcode.makeCode(elText.value);
}

makeCode();

$("#text").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});
	
// Toggle Function
$(".toggle").click(function () {
  // Switches the Icon
  $(this).children("span").toggleClass("x");
    var x = document.getElementsByClassName("tooltip");
  if (x[0].innerHTML === "Source") {
    x[0].innerHTML = "Result";
  } else {
    x[0].innerHTML = ":-)";
  }
  // Switches the forms
  $(".form").animate(
    {
      height: "toggle",
      "padding-top": "toggle",
      "padding-bottom": "toggle",
      opacity: "toggle"
    },
    "slow"
  );
});
