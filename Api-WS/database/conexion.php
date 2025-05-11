<?php
class BaseDatos {
 
    private $host = "localhost";
    private $user = "root";
    private $base = "aseguradora";
    private $port = "";
    private $pass = "";

    public $pdo; // Cambiar a public para permitir el acceso desde fuera de la clase

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->base;charset=utf8";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    // Método para crear un registro y devolver el ID del último registro insertado
    public function create($table, $data) {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute($data)) {
            return true; // Devolver true si todo OK
        } else {
            return false; // Si fallo da false
        }
    }

    // Método para leer un registro
    public function read($table, $joins = [], $where = '', $fields = '*') {
        // Construir la parte SELECT
        $sql = "SELECT $fields FROM $table";
    
        // Añadir los JOINs
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $sql .= " INNER JOIN " . $join;
            }
        }
    
        // Añadir la condición WHERE si existe
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }
    
        // Preparar y ejecutar la consulta
        $stmt = $this->pdo->prepare($sql);

    
        $stmt->execute();
    
        // Obtener los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    // Método para actualizar un registro
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

    // Método para borrar un registro
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
