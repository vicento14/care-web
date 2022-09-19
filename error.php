<?php
if($_SERVER['REDIRECT_STATUS'] == 403)
{
    die("Forbidden");
}
else if($_SERVER['REDIRECT_STATUS'] == 404)
{
    die("NOT FOUND");
}
else if($_SERVER['REDIRECT_STATUS'] == 500)
{
    die("Server Error");
}
?>