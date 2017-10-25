<?php
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
readfile("../errors/404.html");
exit();
?>