<?php
require_once __DIR__ . '/../database/conexion.php';  // Importamos la clase de conexión a la base de datos

class PlanModel {
    private $conn;

    public function __construct() {
        $this->conn = new BaseDatos(); // Instancia de la clase BaseDatos
        $this->conn->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el modo de error a excepción
    }


    /** Info endpoint obtenerPlanes
     * 
     * Función: Obtiene todos los planes de seguros disponibles.
     *
     * @return array|false Lista de planes o false si ocurre un error.
     */

    public function obtenerPlanesVehiculo() {
        try {
            // Realizar la consulta a la base de datos
            return $this->conn->read('planes', [], '', 'id, nombre, precio');

        } catch (PDOException $e) {
            return false;
        }
    }



    /** Info endpoint crearPlan
     * 
     * Función: Crea un nuevo plan de seguros.
     *
     * @param array $data Datos del plan (nombre, precio).
     * @return bool true si la operación fue exitosa, false en caso contrario.
     */

    public function crearPlan($data) {
        try {
            // Realizar la inserción en la base de datos
            return $this->conn->create('planes', $data);
        } catch (PDOException $e) {
            return false;
        }
    }



    /** Info endpoint eliminarPlan
     * 
     * Función: Elimina un plan de seguros por ID.
     *
     * @param int $id ID del plan a eliminar.
     * @return bool true si se eliminó correctamente, false si falló.
     */

    public function eliminarPlan($id) {
        try {
            // Realizar la eliminación en la base de datos
            return $this->conn->delete('planes', ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }


    /** Info endpoint actualizarPlan
     * 
     * Función: Actualiza un plan de seguros por ID.
     * 
     * @param int $id ID del plan a actualizar.
     * @param array $data Datos a actualizar (nombre, precio, etc.).
     * @return bool true si se actualizó correctamente, false si falló.
     */

    public function actualizarPlan($id, $data) {
        try {
            // Realizar la actualización en la base de datos
            return $this->conn->update('planes', $data, ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
