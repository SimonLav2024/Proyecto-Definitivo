<?php

class Validator {
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
        }elseif(strlen($datos["nombre"]) < 2 || strlen($datos["nombre"]) > 50){
            $errors["nombre"] = "El nombre ha de tener entre 2 y 50 caractéres.";
        }elseif(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ' -]+$/u", $datos["nombre"])) {
            $errors["nombre"] = "El nombre no puede contener caractéres especiales.";
        }

        if(!isset($datos["email"]) || empty(trim($datos["email"]))) {
            $errors["email"] = "El email es necesario.";
        }elseif(!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)){
            $errors["email"] = "El formato del email no es valido.";
        }elseif(strlen($datos["email"]) > 255) {
            $errors["email"] = "El email puede ser de máximo 255 caracteres.";
        }
        return $errors;
    }
    public static function validarPelicula($data){
        $errors = [];

        if(!isset($data['titulo']) || empty(trim($data['titulo']))){
            $errors['titulo'] = "El título es necesario";
        }elseif(strlen($data['titulo']) < 2 || strlen($data['titulo']) > 50){
            $errors['titulo'] = "El titulo debe tener entre 2 y 50 caracteres";
        }

        if(!isset($data['precio']) || empty(trim($data['precio']))){
            $errors['precio'] = "El precio es necesario";
        }elseif($data['precio'] < 0){
            $errors['precio'] = "El precio debe ser mayor o igual a 0";
        }

        if(!isset($data['id_director']) || empty(trim($data['id_director']))){
            $errors['id_director'] = "El id del director es necesario";
        }

        return $errors;
    }

    public static function esFormatoFecha($string, $formato = 'Y-m-d') {
        $fecha = DateTime::createFromFormat($formato, $string);
        return $fecha && $fecha->format($formato) === $string;
    }

    public static function esFechaAnteriorHoy($fecha){
        $hoy = new DateTime();
        $fechaAComprobar = new DateTime($fecha);
        return $fechaAComprobar > $hoy;
    }

    public static function validarDirector($data){
        $errors = [];

        if(!isset($data['nombre']) || empty(trim($data['nombre']))){
            $errors['nombre'] = "El nombre es necesario";
        }elseif(strlen($data['nombre']) < 2 || strlen($data['nombre']) > 50){
            $errors['titulo'] = "El nombre debe tener entre 2 y 50 caracteres";
        }

        if(!isset($data['apellido']) || empty(trim($data['apellido']))){
            $errors['apellido'] = "El apellido es necesario";
        }elseif(strlen($data['apellido']) < 2 || strlen($data['apellido']) > 50){
            $errors['apellido'] = "El apellido debe tener entre 2 y 50 caracteres";
        }

        if(isset($data['fecha_nacimiento']) && $data['fecha_nacimiento'] !== ''){
            if(!self::esFormatoFecha($data['fecha_nacimiento'])){
                $errors['fecha_nacimiento'] = "El formato de la fecha no es válido";
            }elseif(self::esFechaAnteriorHoy($data['fecha_nacimiento'])){
                $errors['fecha_nacimiento'] = "La fecha de nacimiento no puede ser futura";
            }
        }

        if(isset($data['biografia']) && strlen($data['biografia']) > 65500){
            $errors['biografia'] = "La biografía es demasiado extensa";
        }

        return $errors;       
    }
}