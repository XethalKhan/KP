<?php

if($_SERVER['CONTENT_TYPE'] === 'application/json'){
    require_once 'src/json.php';
} else if($_SERVER['CONTENT_TYPE'] === 'application/xml'){
    require_once 'src/xml.php';
} else {
    require_once 'src/html.php';
}
