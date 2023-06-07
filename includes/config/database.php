<?php

    function conectarDB() : mysqli{
        $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');

        if(!$db) {
          echo "No se conecto a la base de datos";
          exit;
        }

        return $db;
    }