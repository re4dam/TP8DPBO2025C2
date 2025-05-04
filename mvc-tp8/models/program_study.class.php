<?php
require_once 'config/db.php';

class ProgramStudy
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    public function getAllProgramStudies()
    {
        $stmt = $this->conn->prepare("SELECT * FROM program_study");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProgramStudyById(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM program_study WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProgramStudy(string $nama, string $kode, int $id_faculty)
    {
        $stmt = $this->conn->prepare("INSERT INTO program_study (nama, kode, id_faculty) VALUES (:nama, :kode, :id_faculty)");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kode', $kode);
        $stmt->bindParam(':id_faculty', $id_faculty);
        return $stmt->execute();
    }

    public function updateProgramStudy(int $id, string $nama, string $kode, int $id_faculty)
    {
        $stmt = $this->conn->prepare("UPDATE program_study SET nama = :nama, kode = :kode, id_faculty = :id_faculty WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kode', $kode);
        $stmt->bindParam(':id_faculty', $id_faculty);
        return $stmt->execute();
    }

    public function deleteProgramStudy(int $id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM program_study WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return the exception to be handled by the controller
            throw $e;
        }
    }
}
