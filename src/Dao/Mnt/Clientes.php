<?php

namespace Dao\Mnt;

use Dao\Table;
use DateTime;

class Clientes extends Table
{

    public static function insert(
        string $clientname,
        string $clientgender,
        string $clientphone1,
        string $clientphone2,
        string $clientemail,
        string $clientIdnumber,
        string $clientbio,
        string $clientstatus = "ACT",
        // DateTime $clientdatecrt,
        int $clientusercreates
    ): int {
        $sqlstr = "INSERT INTO clientes 
                    (clientname, clientgender, clientphone1, clientphone2, clientemail, clientIdnumber, clientbio, clientstatus, 
                    clientdatecrt, clientusercreates)
                    values(:clientname, :clientgender, :clientphone1, :clientphone2, :clientemail, :clientIdnumber, :clientbio, :clientstatus, 
                    :clientdatecrt, :clientusercreates);";

        $rowsInserted = self::executeNonQuery(
            $sqlstr,
            array(
                "clientname" => $clientname,
                "clientgender" => $clientgender,
                "clientphone1" => $clientphone1,
                "clientphone2" => $clientphone2,
                "clientemail" => $clientemail,
                "clientIdnumber" => $clientIdnumber,
                "clientbio" => $clientbio,
                "clientstatus" => $clientstatus,
                "clientdatecrt" => date('Y-m-d'),
                "clientusercreates" => $clientusercreates
            )
        );
        return $rowsInserted;
    }

    public static function update(
        string $clientname,
        string $clientgender,
        string $clientphone1,
        string $clientphone2,
        string $clientemail,
        string $clientIdnumber,
        string $clientbio,
        string $clientstatus,
        // DateTime $clientdatecrt,
        int $clientusercreates,
        int $clientid
    ) {
        $sqlstr = "UPDATE clientes SET clientname = :clientname, clientgender = :clientgender, clientphone1 = :clientphone1,
                    clientphone2 = :clientphone2, clientemail = :clientemail, clientIdnumber = :clientIdnumber, clientbio = :clientbio,
                    clientstatus = :clientstatus, clientusercreates = :clientusercreates WHERE clientid = :clientid;";

        $rowsUpdated = self::executeNonQuery(   
            $sqlstr,
            array(
                "clientname" => $clientname,
                "clientgender" => $clientgender,
                "clientphone1" => $clientphone1,
                "clientphone2" => $clientphone2,
                "clientemail" => $clientemail,
                "clientIdnumber" => $clientIdnumber,
                "clientbio" => $clientbio,
                "clientstatus" => $clientstatus,
                "clientusercreates" => $clientusercreates,
                "clientid" => $clientid,
            )
        );
        return $rowsUpdated;
    }

    public static function delete(int $clientid)
    {
        $sqlstr = "DELETE from clientes where clientid = :clientid;";
        $rowsDeleted = self::executeNonQuery(
            $sqlstr,
            array(
                "clientid" => $clientid
            )
        );
        return $rowsDeleted;
    }
    public static function findAll()
    {
        $sqlstr = "SELECT * from clientes;";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function findByFilter()
    {
    }

    public static function findById(int $clientid)
    {
        $sqlstr = "SELECT * from clientes where clientid = :clientid;";
        $row = self::obtenerUnRegistro(
            $sqlstr,
            array(
                "clientid" => $clientid
            )
        );
        return $row;
    }
}
