<?php
require_once "config/db.php";

class Faculty
{
    private $db;

    function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function getAllFaculties()
    {
        $query = "SELECT * FROM faculty";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFacultyById(int $id)
    {
        $query = "SELECT * FROM faculty WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFaculty(string $nama, string $kode)
    {
        $query = "INSERT INTO faculty (nama, kode) VALUES (:nama, :kode)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kode', $kode);
        return $stmt->execute();
    }

    public function updateFaculty(int $id, string $nama, string $kode)
    {
        $query = "UPDATE faculty SET nama = :nama, kode = :kode WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':kode', $kode);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteFaculty(int $id)
    {
        try {
            $query = "DELETE FROM faculty WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) { // Return the exception to be handled by the controller
            throw $e;
        }
    }
}
