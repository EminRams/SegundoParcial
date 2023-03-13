<?php

namespace Dao\Mnt;

use Dao\Table;
use DateTime;

class Users extends Table
{

    public static function insert(
        string $useremail, 
        string $username, 
        string $userpswd,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ): int {
        $sqlstr = "INSERT INTO usuario 
                    (useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, 
                    userpswdchg, usertipo)
                    values(:useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, 
                    :userpswdchg, :usertipo);";

        $userfching = date('Y-m-d');
        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "useremail" => $useremail,
                "username" => $username,
                "userpswd" => $userpswd,
                "userfching" => $userfching,
                "userpswdest" => $userpswdest,
                "userpswdexp" => $userpswdexp,
                "userest" => $userest,
                "useractcod" => $useractcod,
                "userpswdchg" => $userpswdchg,
                "usertipo" => $usertipo
            )
        );
        return $rowsInserted;
    }

    public static function update(
        string $useremail,
        string $username,
        string $userpswd,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo,
        string $usercod
    ) {
        $sqlstr = "UPDATE usuario SET useremail = :useremail, username = :username, userpswd = :userpswd,
                    userpswdest = :userpswdest, userpswdexp = :userpswdexp, userest = :userest, useractcod = :useractcod,
                    userpswdchg = :userpswdchg, usertipo = :usertipo WHERE usercod = :usercod;";

        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "useremail" => $useremail,
                "username" => $username,
                "userpswd" => $userpswd,
                "userpswdest" => $userpswdest,
                "userpswdexp" => $userpswdexp,
                "userest" => $userest,
                "useractcod" => $useractcod,
                "userpswdchg" => $userpswdchg,
                "usertipo" => $usertipo,
                "usercod" => $usercod
                )
        );
        return $rowsUpdated;
    }

    public static function delete(int $usercod)
    {
        $sqlstr = "DELETE from usuario where usercod = :usercod;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "usercod" => $usercod
            )
        );
        return $rowsDeleted;
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * from usuario;";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function findByFilter()
    {
    }

    public static function findById(int $usercod)
    {
        $sqlstr = "SELECT * from usuario where usercod = :usercod;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "usercod" => $usercod
            )
        );
        return $row;
    }
}
