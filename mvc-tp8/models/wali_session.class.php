<?php
require_once 'config/db.php';

class WaliSession
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    public function getAllWaliSessions()
    {
        $stmt = $this->conn->prepare("SELECT * FROM wali_session");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWaliSessionById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM wali_session WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addWaliSession($id_student, $id_lecturer, $tanggal, $topik, $status, $catatan)
    {
        $stmt = $this->conn->prepare("INSERT INTO wali_session (id_student, id_lecturer, tanggal, topik, status, catatan) 
            VALUES (:id_student, :id_lecturer, :tanggal, :topik, :status, :catatan)");
        $stmt->bindParam(':id_student', $id_student);
        $stmt->bindParam(':id_lecturer', $id_lecturer);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':topik', $topik);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':catatan', $catatan);
        return $stmt->execute();
    }

    public function updateWaliSession($id, $id_student, $id_lecturer, $tanggal, $topik, $status, $catatan)
    {
        $stmt = $this->conn->prepare("UPDATE wali_session SET 
            id_student = :id_student, id_lecturer = :id_lecturer, tanggal = :tanggal,
            topik = :topik, status = :status, catatan = :catatan
            WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_lecturer', $id_lecturer);
        $stmt->bindParam(':id_student', $id_student);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':topik', $topik);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':catatan', $catatan);
        return $stmt->execute();
    }

    public function deleteWaliSession($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM wali_session WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return the exception to be handled by the controller
            throw $e;
        }
    }
}
