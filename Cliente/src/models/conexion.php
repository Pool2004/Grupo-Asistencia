<?php
/**
 * Clase BaseDatos
 *
 * Esta clase encapsula la conexión a una base de datos MySQL mediante PDO,
 * y proporciona métodos genéricos para operaciones CRUD (crear, leer, actualizar y eliminar).
 * Es utilizada como capa de abstracción dentro del modelo en arquitecturas tipo MVC o desacopladas.
 *
 * Métodos:
 * - __construct(): Conecta automáticamente a la base de datos al instanciar la clase.
 * - create($table, $data): Inserta un nuevo registro en la tabla especificada.
 * - read($table, $joins = [], $where = '', $fields = '*'): Consulta registros con soporte para JOINs y condiciones WHERE.
 * - update($table, $data, $where): Actualiza registros que cumplan una o más condiciones.
 * - delete($table, $where): Elimina registros basados en una o varias condiciones.
 *
 * @author Dev Jean Paul Ordóñez
 * @date   11/05/2025
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
     * @return bool true si la inserción fue exitosa, false en caso contrario.
     */
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

    /**
     * Consulta registros de una tabla con soporte para JOINs y condiciones WHERE.
     *
     * @param string $table Nombre de la tabla.
     * @param array $joins Array de JOINs (ej. ['tabla2 ON tabla1.id = tabla2.id']).
     * @param string $where Condición WHERE (ej. 'id = 1').
     * @param string $fields Campos a seleccionar (ej. 'id, nombre').
     * @return array Resultados de la consulta.
     */
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
    
    
    /**
     * Actualiza registros en la tabla especificada.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos a actualizar (clave => valor).
     * @param array $where Condiciones para la actualización (clave => valor).
     * @return bool true si la actualización fue exitosa, false en caso contrario.
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
