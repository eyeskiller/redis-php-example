<?php
session_start();
?>

<h2> Ahoj Lubos (<?php echo $_COOKIE['PHPSESSID']; ?>) </h2>
<p>Teraz ukazujem adminom, ze si tu... ty smejd!</p>

<script type="text/javascript">
var xhttp = new XMLHttpRequest();
window.setInterval(function(){
    xhttp.open("POST", "alive.php?sess=<?php echo $_COOKIE['PHPSESSID']; ?>", true);
    xhttp.send();
}, 1000);
</script>
