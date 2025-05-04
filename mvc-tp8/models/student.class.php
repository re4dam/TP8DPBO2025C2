<?php
require_once 'config/db.php';

class Student
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->conn;
    }

    public function getAllStudents()
    {
        $stmt = $this->conn->prepare("SELECT * FROM student");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM student WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addStudent($nama, $nim, $gender, $phone, $email, $birth_date, $address, $angkatan, $id_program_study, $id_lecturer)
    {
        $stmt = $this->conn->prepare("INSERT INTO student 
            (nama, nim, gender, email, phone, birth_date, address, angkatan, id_program_study, id_lecturer) 
            VALUES 
            (:nama, :nim, :gender, :email, :phone, :birth_date, :address, :angkatan, :id_program_study, :id_lecturer)");
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':angkatan', $angkatan);
        $stmt->bindParam(':id_program_study', $id_program_study);
        $stmt->bindParam(':id_lecturer', $id_lecturer);
        return $stmt->execute();
    }

    public function updateStudent($id, $nama, $nim, $gender, $phone, $email, $birth_date, $address, $angkatan, $id_program_study, $id_lecturer)
    {
        $stmt = $this->conn->prepare("UPDATE student SET 
            nama = :nama, nim = :nim, gender = :gender, phone = :phone, email = :email,
            birth_date = :birth_date, address = :address, angkatan = :angkatan,
            id_program_study = :id_program_study, id_lecturer = :id_lecturer
            WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':angkatan', $angkatan);
        $stmt->bindParam(':id_program_study', $id_program_study);
        $stmt->bindParam(':id_lecturer', $id_lecturer);
        return $stmt->execute();
    }

    public function deleteStudent($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM student WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Return the exception to be handled by the controller
            throw $e;
        }
    }
}
