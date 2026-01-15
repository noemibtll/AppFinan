<?php
    define("ROOT", str_replace('\\', '/', dirname(dirname(__FILE__))).'/');
    $url_server = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'];

    // Detectar si es local o hosting
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $base_url = $url_server."/AppFinanciera"; // carpeta local
    } else {
        $base_url = $url_server; // hosting
    }

    define("BASE_URL", $base_url."/");
    define("SRC_DIR", ROOT . "src/");
    define("JS_DIR", $base_url."/js");
    define("CSS_DIR", $base_url."/css");
    define("IMG_DIR", $base_url."/img");
    define("PAGES_DIR", $base_url."/pages");
    define("PHP_DIR", $base_url."/php");

    define("WROOT", $url_server);
    define("DOMINIO", ".".$_SERVER['HTTP_HOST']);
?>
