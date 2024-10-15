
<html>
<head>
  <meta name="description" content="QR Code scanner" />
  <meta name="keywords" content="qrcode,qr code,scanner,barcode,javascript" />
  <meta name="language" content="English" />
  <meta name="copyright" content="Lazar Laszlo (c) 2011" />
  <meta name="Revisit-After" content="1 Days"/>
  <meta name="robots" content="index, follow"/>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Web QR</title>

<style type="text/css">
body{
    margin: 0px auto;
    padding: 0;
    width:100%;
    text-align:center;

}
img{
    border:0;
}
#main{
    margin: 0px auto;
    padding: 5px;
    overflow: auto;
    background-color: pink; /* For browsers that do not support gradients */
    background-image: linear-gradient(pink , white);
}
#header{
    background:none;
    margin-bottom:5px;
    color: purple;
    font-family: Arial, Helvetica, sans-serif;
}
#mainbody{
    background: none;
    display:none;
}
#footer{
    background:none;
    color: #6f3e8a;
font-family: Arial, Helvetica, sans-serif;
align:center;
margin-top:5px;
}
#v{
  width: 100%;
  height: auto;
border-radius: 10px;
}
#qr-canvas{
    display:none;
}
#qrfile{
    width:320px;
    height:320px;
}
#mp1{
    text-align:center;
    font-size:25px;
margin-top:5px;
margin-bottom:5px;
}
#imghelp{
    position:relative;
    left:0px;
    top:-160px;
    z-index:100;
    font:18px arial,sans-serif;
    background:#f0f0f0;
	margin-left:35px;
	margin-right:35px;
	padding-top:10px;
	padding-bottom:10px;
	border-radius:20px;
}
.selector{
    margin:0;
    padding:0;
    cursor:pointer;
    margin-bottom:-5px;
}
#outdiv
{
    width:320px;
    height:auto;
    border: none;
    outline: none;
    margin-top:10px;
}
#result{
	width:320px;
	height:100px;
	text-align: center;
	border: 1px dashed #1c87c9;
	border-radius: 10px;
	outline: none;
	display: table-cell;
    	background: none;
	vertical-align: middle;
      	align-items:center;
        justify-content:center;
	font-family:monospace;
}
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-size: 1.5em;
            /* Larger, responsive font size */
            margin-bottom: 20px;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
#footer a{
	color: purple;
}
.tsel{
  padding:5px;
  border-radius: 12px;
  border: 2px solid #eb88a7;
}

</style>

<script type="text/javascript" src="llqrcode.js"></script>

<script type="text/javascript" src="webqr.js"></script>
<script>
function copyClipboard() {
  var copyText = document.getElementById("result").value;
//  copyText.setSelectionRange(0, 99999); // For mobile devices
  navigator.clipboard.writeText(copyText);
  alert("Copied the selected text");
}

</script>

</head>

<body>
<div id="main">
<div id="header">
<div style="position:relative;top:+20px;left:0px;"><g:plusone size="medium"></g:plusone></div>
<p id="mp1">
</p>

</div>
<div id="mainbody">
<table class="tsel" align="center" border="0" width="350px">
<tr>
<td valign="top" align="center" width="50%">
<table border="0">
<tr>
<td><img class="selector" id="webcamimg" src="cam.png" onclick="setwebcam()" align="left" />
<img class="selector" id="qrimg" src="folder.png" onclick="setimg()" align="left"/></td>
<td><img class="selector" src="chrome.png" onclick="document.location = 'googlechrome://navigate?url=https://darojatun.github.io/webqr/';" align="right"/>
<img class="selector" src="reload.png" onclick="location.reload();" align="right"/></td></tr>
<tr><td colspan="2" align="center">
<div id="outdiv">
</div></td></tr>
</table>
</td>
</tr>
<tr><td colspan="3" align="center">

</td></tr>
<tr><td colspan="3" align="center">
<div id="result" onclick="this.focus();this.select();copyClipboard()" readonly="readonly"></div>
</td></tr>
</table>
</div>
<div id="footer">
&copy;2021 <a target="_blank" href="http://djatun.com">Darojatun</a>
</div>
</div>
<canvas id="qr-canvas" width="800" height="600"></canvas>
<script type="text/javascript">load();</script>
</body>
</html>
