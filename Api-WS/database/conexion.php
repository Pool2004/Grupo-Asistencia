<?php

/**
 * Conexion.php
 * 
 * Clase para la conexión a la base de datos MySQL utilizando PDO.
 * - Crear, actualizar y eliminar registros en la base de datos.
 * 
 * Esta clase se utiliza para interactuar con la base de datos de la aseguradora.
 * 
 * Autor: Dev Jean Paul Ordoñez
 * Fecha: 10/05/2025
 */

class BaseDatos {
    
    /**
     * @var string Servidor de la base de datos
     */
    private $host = "localhost";

    /**
     * @var string Usuario de la base de datos
     */
    private $user = "root";

    /**
     * @var string Nombre de la base de datos
     */
    private $base = "aseguradora";

    /**
     * @var string Puerto de la base de datos
     */
    private $port = "";

    /**
     * @var string Contraseña de la base de datos
     */
    private $pass = "";


    /**
     * @var PDO Instancia de la conexión PDO
     */
    public $pdo; 


    /**
     * Constructor: establece la conexión a la base de datos.
     */

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->base;charset=utf8";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }


    /**
     * Inserta un nuevo registro en la tabla especificada.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos a insertar (clave => valor).
     * @return bool true si se insertó correctamente, false si falló.
     */

    public function create($table, $data) {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute($data)) {
            return true; 
        } else {
            return false; 
        }
    }



    /**
     * Lee registros de una tabla, con soporte opcional para JOINs y condiciones WHERE.
     *
     * @param string $table Nombre de la tabla.
     * @param array $joins Arreglo con las instrucciones JOIN (formato SQL).
     * @param string $where Condición WHERE (opcional).
     * @param string $fields Campos a seleccionar (por defecto '*').
     * @return array Arreglo de resultados (asociativos).
     */
    public function read($table, $joins = [], $where = '', $fields = '*') {
 
        $sql = "SELECT $fields FROM $table";
    
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " INNER JOIN " . $join;
            }
        }
    
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }
  
        $stmt = $this->pdo->prepare($sql);

    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    /**
     * Actualiza un registro en una tabla.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos a actualizar.
     * @param array $where Condición de filtrado (clave => valor).
     * @return bool true si se actualizó correctamente, false si falló.
     */
    public function update($table, $data, $where) {
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }
        $sql = "UPDATE $table SET " . implode(", ", $setParts);
        $conditions = [];
        foreach ($where as $column => $value) {
            $conditions[] = "$column = :where_$column";
        }
        $sql .= " WHERE " . implode(" AND ", $conditions);
        $stmt = $this->pdo->prepare($sql);
    
        foreach ($where as $column => $value) {
            $data["where_$column"] = $value;
        }
    
        return $stmt->execute($data);
    }

    

    /**
     * Elimina registros de una tabla según una condición.
     *
     * @param string $table Nombre de la tabla.
     * @param array $where Condición de filtrado (clave => valor).
     * @return bool true si se eliminó correctamente, false si falló.
     */
    public function delete($table, $where) {
        $conditions = [];
        foreach ($where as $column => $value) {
            $conditions[] = "$column = :$column";
        }
        $sql = "DELETE FROM $table WHERE " . implode(" AND ", $conditions);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($where);
    }

    
}

?>
