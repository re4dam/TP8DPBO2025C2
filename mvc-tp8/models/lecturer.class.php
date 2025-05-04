<?php
require_once 'config/db.php';

class Lecturer
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    public function getAllLecturers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM lecturer");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLecturerById(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lecturer WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addLecturer(string $nama, string $nip, string $phone, $work_date, $join_date, int $id_program_study)
    {
        $stmt = $this->conn->prepare("INSERT INTO lecturer (nama, nip, phone, work_date, join_date, id_program_study) 
                                      VALUES (:nama, :nip, :phone, :work_date, :join_date, :id_program_study)");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nip', $nip);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':work_date', $work_date);
        $stmt->bindParam(':join_date', $join_date);
        $stmt->bindParam(':id_program_study', $id_program_study);
        return $stmt->execute();
    }

    public function updateLecturer(int $id, string $nama, string $nip, string $phone, $work_date, $join_date, int $id_program_study)
    {
        $stmt = $this->conn->prepare("UPDATE lecturer SET nama = :nama, nip = :nip, phone = :phone, 
                                      work_date = :work_date, join_date = :join_date, id_program_study = :id_program_study 
                                      WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nip', $nip);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':work_date', $work_date);
        $stmt->bindParam(':join_date', $join_date);
        $stmt->bindParam(':id_program_study', $id_program_study);
        return $stmt->execute();
    }

    public function deleteLecturer(int $id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM lecturer WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return the exception to be handled by the controller
            throw $e;
        }
    }
}
