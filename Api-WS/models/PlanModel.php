<?php
require_once __DIR__ . '/../database/conexion.php';

class PlanModel {
    private $conn;

    public function __construct() {
        $this->conn = new BaseDatos(); // Instancia de la clase BaseDatos
        $this->conn->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el modo de error a excepción
    }

    public function obtenerPlanesVehiculo() {
        try {
            // Realizar la consulta a la base de datos
            return $this->conn->read('planes', [], '', 'id, nombre, precio');

        } catch (PDOException $e) {
            return false;
        }
    }

    public function crearPlan($data) {
        try {
            // Realizar la inserción en la base de datos
            return $this->conn->create('planes', $data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminarPlan($id) {
        try {
            // Realizar la eliminación en la base de datos
            return $this->conn->delete('planes', ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizarPlan($id, $data) {
        try {
            // Realizar la actualización en la base de datos
            return $this->conn->update('planes', $data, ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
