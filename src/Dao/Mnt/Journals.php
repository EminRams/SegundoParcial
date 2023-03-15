<?php

namespace Dao\Mnt;

use Dao\Dao;
use Dao\Table;
use DateTime;

class Journals extends Table
{

    public static function insert(
        string $journal_date,
        string $journal_type,
        string $journal_description,
        float $journal_amount,
        string $created_at
    ): int {
        $sqlstr = "INSERT INTO journals 
                    (journal_date, journal_type, journal_description, journal_amount, created_at)
                    values(:journal_date, :journal_type, :journal_description, :journal_amount, :created_at);";

        if($created_at){
            $hoy = $created_at;
        } else {
           $hoy = date("Y-m-d H:i:s"); 
        }

        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "journal_date" => $journal_date,
                "journal_type" => $journal_type,
                "journal_description" => $journal_description,
                "journal_amount" => $journal_amount,
                "created_at" => $hoy,
            )
        );
        return $rowsInserted;
    }

    public static function update(
        string $journal_date,
        string $journal_type,
        string $journal_description,
        float $journal_amount,
        int $journal_id
    ) {
        $sqlstr = "UPDATE journals SET journal_date = :journal_date, journal_type = :journal_type, journal_description = :journal_description,
                    journal_amount = :journal_amount WHERE journal_id = :journal_id;";

        $rowsUpdated = self::executeNonQuery(
            $sqlstr,
            array(
                "journal_date" => $journal_date,
                "journal_type" => $journal_type,
                "journal_description" => $journal_description,
                "journal_amount" => $journal_amount,
                "journal_id" => $journal_id
            )
        );
        return $rowsUpdated;
    }

    public static function delete(int $journal_id)
    {
        $sqlstr = "DELETE from journals where journal_id = :journal_id;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "journal_id" => $journal_id
            )
        );
        return $rowsDeleted;
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * from journals;";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function findByFilter()
    {
    }

    public static function findById(int $journal_id)
    {
        $sqlstr = "SELECT * from journals where journal_id = :journal_id;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "journal_id" => $journal_id
            )
        );
        return $row;
    }
}
