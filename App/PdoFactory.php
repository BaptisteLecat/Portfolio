<?php

namespace App;

use App\Model\Settings\XMLAppConfig;

class PdoFactory
{
    private static $pdo;
    private static $appSettings;

    public static function initConnection()
    {
        self::$appSettings = new XMLAppConfig($_SERVER['DOCUMENT_ROOT'] . "/../config/config.xml", null, true);
        $dbInfo = self::$appSettings->getDBCredentials();
        $dsn = 'mysql:dbname=' . $dbInfo["dbName"] . ';host=' . $dbInfo["dbHost"];
        self::$pdo = new \PDO($dsn, $dbInfo["dbUser"], $dbInfo["dbPassword"]);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public static function getPdo()
    {
        if (is_null(self::$pdo)) {
            self::initConnection();
        }

        return self::$pdo;
    }
}
