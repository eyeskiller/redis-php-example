<?php
session_start();
?>

<h2> Ludia Online</h2>
<p id="list"></p>

<script type="text/javascript">
var xhttp = new XMLHttpRequest();
window.setInterval(function(){
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("list").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "getAlive.php", true);
    xhttp.send();
}, 1000);
</script>
