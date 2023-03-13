<?php

namespace Dao\Mnt;

use Dao\Table;
use DateTime;

class Funciones extends Table
{

    public static function insert(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ): int {
        $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp) values(:fncod, :fndsc, :fnest, :fntyp);";

        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp,
            )
        );
        return $rowsInserted;
    }

    public static function update(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $sqlstr = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp WHERE fncod = :fncod;";

        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp,
            )
        );
        return $rowsUpdated;
    }

    public static function delete(int $fncod)
    {
        $sqlstr = "DELETE from funciones where fncod = :fncod;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "fncod" => $fncod
            )
        );
        return $rowsDeleted;
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function findByFilter()
    {
    }

    public static function findById(int $fncod)
    {
        $sqlstr = "SELECT * from funciones where fncod = :fncod;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "fncod" => $fncod
            )
        );
        return $row;
    }
}
