<?php

class Bd {
    public static function conexion(){
        $conexion= new mysqli('localhost', 'root', '', 'virtualmarket'); 
        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }
}