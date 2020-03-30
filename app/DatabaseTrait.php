<?php

trait DatabaseTrait {

    /**
     * Make connection to database
     *
     * @return $db
     */
    public static function makeConnection()
    {
        $user = 'root';
        $password = '';
        $database = 'am-impact-test';
        $host = 'localhost';

        try {
            $db = new \PDO('mysql:host='.$host.';dbname='.$database.'', $user, $password);
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $db;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}