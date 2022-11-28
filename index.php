<?php

if($_SERVER['CONTENT_TYPE'] === 'application/json'){
    require_once 'src/json.php';
} else {
    require_once 'src/html.php';
}
