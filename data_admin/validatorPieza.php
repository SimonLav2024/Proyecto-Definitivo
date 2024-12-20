<?php

class ValidatorPieza {
    public static function sanear($datos): array {
        $saneados = [];
        foreach ($datos as $key => $value) {
            $saneados[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES,"UTF-8");
        }
        return $saneados;
    }

    public static function validar($datos) {
        $errors = [];
        if(!isset($datos["nombre"]) || empty(trim($datos["nombre"]))) {
            $errors["nombre"] = "El nombre es necesario.";
        }elseif(strlen($datos["nombre"]) < 0 || strlen($datos["nombre"]) > 300){
            $errors["nombre"] = "El nombre ha de tener entre 0 y 300 caractéres.";
        }

        if(!isset($datos["precio"]) || empty(trim($datos["precio"]))) {
            $errors["precio"] = "El precio es necesario.";
        }elseif(!filter_var($datos["precio"], FILTER_VALIDATE_FLOAT) || is_float($datos["precio"])){
            $errors["precio"] = "El formato del precio no es valido.";
        }elseif(strlen($datos["precio"]) > 5) {
            $errors["precio"] = "El precio no puede ser mayor de 99999.";
        }

        if(!isset($datos["marca_pieza"]) || empty(trim($datos["marca_pieza"]))) {
            $errors["marca_pieza"] = "La marca de la pieza es necesario.";
        }elseif(strlen($datos["marca_pieza"]) < 0 || strlen($datos["marca_pieza"]) > 300){
            $errors["marca_pieza"] = "La marca ha de tener entre 0 y 300 caractéres.";
        }

        if(!isset($datos["coche_compatible"]) || empty(trim($datos["coche_compatible"]))) {
            $errors["coche_compatible"] = "Los coches compatibles con la pieza son necesarios.";
        }elseif(strlen($datos["coche_compatible"]) < 0 || strlen($datos["coche_compatible"]) > 300){
            $errors["coche_compatible"] = "Los coches compatibles con la pieza han de tener entre 0 y 300 caractéres.";
        }

        return $errors;
    }
}