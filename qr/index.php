<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>QRCode Generator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="description" content="Javascript QRCode Generator Online">
  <meta name="keywords" content="qrcode, qrcode generator, qr, qr code">
  <meta name="author" content="Darojatun">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="qrcode.js"></script>

<style type="text/css">

html {
  min-height:100%;
  overflow-x:hidden;
  background: #a2a09b;
  background:-webkit-linear-gradient(315deg,hsla(236.6,0%,53.52%,1) 0,hsla(236.6,0%,53.52%,0) 70%),-webkit-linear-gradient(65deg,hsla(220.75,34.93%,26.52%,1) 10%,hsla(220.75,34.93%,26.52%,0) 80%),-webkit-linear-gradient(135deg,hsla(46.42,36.62%,83.92%,1) 15%,hsla(46.42,36.62%,83.92%,0) 80%),-webkit-linear-gradient(205deg,hsla(191.32,50.68%,56.45%,1) 100%,hsla(191.32,50.68%,56.45%,0) 70%);
  background:linear-gradient(135deg,hsla(236.6,0%,53.52%,1) 0,hsla(236.6,0%,53.52%,0) 70%),linear-gradient(25deg,hsla(220.75,34.93%,26.52%,1) 10%,hsla(220.75,34.93%,26.52%,0) 80%),linear-gradient(315deg,hsla(46.42,36.62%,83.92%,1) 15%,hsla(46.42,36.62%,83.92%,0) 80%),linear-gradient(245deg,hsla(191.32,50.68%,56.45%,1) 100%,hsla(191.32,50.68%,56.45%,0) 70%);
 }
body {
 font-family: "RobotoDraft", "Roboto", sans-serif;
  font-size: 14px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Pen Title */
.pen-title {
  padding: 50px 0;
  text-align: center;
  letter-spacing: 2px;
}
.pen-title h1 {
  margin: 0 0 20px;
  font-size: 32px;
  font-weight: 300;
}
.pen-title span {
  font-size: 12px;
}

.pen-title span a {
  color: #33b5e5;
  font-weight: 600;
  text-decoration: none;
}

/* Form Module */
.form-module {
  position: relative;
  background: #ffffff;
  max-width: 320px;
  width: 100%;
  border-top: 5px solid #33b5e5;
  box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
  margin: 0 auto;
}
.form-module .toggle {
  cursor: pointer;
  position: absolute;
  top: 0;
  right: 0;
  background: #33b5e5;
  width: 30px;
  height: 30px;
  margin: -5px 0 0;
  color: #ffffff;
  font-size: 12px;
  line-height: 30px;
  text-align: center;
}
.form-module .toggle .tooltip {
  position: absolute;
  top: 5px;
  right: -45px;
  display: block;
  background: rgba(0, 0, 0, 0.65);
  border-radius: 5px;
  width: auto;
  padding: 5px;
  font-size: 10px;
  line-height: 1;
  text-transform: uppercase;
  writing-mode: vertical-rl;
  text-orientation: mixed;
}
.form-module .toggle .tooltip:before {
  content: "";
  position: absolute;
  top: 5px;
  left: -5px;
  display: block;
  border-top: 5px solid transparent;
  border-bottom: 5px solid transparent;
  border-right: 5px solid rgba(0, 0, 0, 0.6);
}
.form-module .form {
  display: none;
  padding: 40px;
}
.form-module .form:nth-child(2) {
  display: block;
}
.form-module h2 {
  margin: 0 0 20px;
  color: #33b5e5;
  font-size: 18px;
  font-weight: 400;
  line-height: 1;
}
.form-module textarea {
  width: 100%;
  resize: none;
  height: 210px;
  outline: none;
  display: block;
  border: 1px solid #d9d9d9;
  margin: 0 0 20px;
  padding: 10px 15px;
  box-sizing: border-box;
  font-weight: 400;
  transition: 0.3s ease;
}
.form-module textarea:focus {
  border: 1px solid #33b5e5;
  color: #333333;
}

.form-module .cta {
  background: #f2f2f2;
  width: 100%;
  padding: 15px 40px;
  box-sizing: border-box;
  color: #666666;
  font-size: 12px;
  text-align: center;
}
.form-module .cta a {
  color: #333333;
  text-decoration: none;
}
.pencil {
	width: 30px;
	height: 30px;
	background-image: url('pencil.svg');
	background-repeat: no-repeat;
	background-position: center; 
	display:block;

}

.x {
	width: 30px;
	height: 30px;
	background-image: url('qr-code.svg');
	background-repeat: no-repeat;
	background-position: center; 
	display:block;
}



    </style>
</head>
<body onload="qrUrl()">

<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
  <h1>QRCode Generator</h1><span>&lt;javascript&gt;</span>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle"><span class="pencil"></span>
    <div class="tooltip">Source</div>
  </div>
  <div class="form">
    <h2>Scan this QRCode</h2>
<div id="qrcode"></div>
  </div>
  <div class="form">
    <h2>Generate a QRCode</h2>
      <textarea id="text" onfocus="this.value=''" rows="10" cols="10"></textarea>
  </div>
  <div class="cta"><a href="https://djatun.com">&copy;2021 Darojatun</a></div>
</div>


<script type="text/javascript">

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

</script>
</body>
</html>
