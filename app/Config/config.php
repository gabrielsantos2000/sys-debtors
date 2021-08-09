<?php

/** Definindo a URL BASE do sistema */
$baseUrl = $_SERVER['URL_WWW'] ?? "http://localhost:80/sys-debtors/";
define("BASE_URL", $baseUrl);

/** Adicionando os caminhos relativos do sistema */
$pathRoot   = $_SERVER['DOCUMENT_ROOT'] . "/devedores/";
$pathPublic = $pathRoot . "public/"; 

/** Adicionando as configurações do DB */
define("DB_CONFIG", [
        "server" => $_SERVER["DB_HOST"] ?? "localhost",
        "port" => $_SERVER["DB_PORT"] ?? 3306,
        "uid" => $_SERVER["DB_USER"] ?? "root",
        "pass" => $_SERVER["DB_PASS"] ?? "",
        "dbname" => "db_devedores",
        "utf8" => true,
    ]
);