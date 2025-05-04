<?php
require_once 'models/faculty.class.php';
require_once 'views/faculty.view.php';

class FacultyController
{
    private $faculty;
    private $view;

    public function __construct()
    {
        $this->faculty = new Faculty();
        $this->view = new FacultyView('index.php?action=');
    }

    public function index()
    {
        $data = $this->faculty->getAllFaculties();
        $this->view->renderList($data);
    }

    public function create()
    {
        // If form is submitted
        if (isset($_POST['submit'])) {
            $data = [
                'nama' => $_POST['nama'],
                'nim' => $_POST['nim'],
                'phone' => $_POST['phone'],
                'join_date' => $_POST['join_date']
            ];
            $nama = $_POST['nama'];
            $kode = $_POST['kode'];

            $result = $this->faculty->addFaculty($nama, $kode);
            if ($result) {
                header("Location: index.php");
                exit;
            }
        }

        // Display the form
        $this->view->renderForm();
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php");
            exit;
        }

        // If form is submitted
        if (isset($_POST['submit'])) {
            $data = [
                'id' => $_POST['id'],
                'nama' => $_POST['nama'],
                'nim' => $_POST['nim'],
                'phone' => $_POST['phone'],
                'join_date' => $_POST['join_date']
            ];
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $kode = $_POST['kode'];

            $result = $this->faculty->updateFaculty($id, $nama, $kode);
            if ($result) {
                header("Location: index.php");
                exit;
            }
        }

        // Get student data and display form
        $faculty = $this->faculty->getFacultyById($id);
        if ($faculty) {
            $this->view->renderForm($faculty, true);
        } else {
            header("Location: index.php");
            exit;
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $result = $this->faculty->deleteFaculty($id);
                if ($result) {
                    header("Location: index.php");
                    exit;
                }
            } catch (PDOException $e) {
                // Check if it's a foreign key constraint violation
                if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
                    header("Location: index.php?error=foreign_key&message=Cannot+delete+faculty.+It+is+being+referenced+by+program+study+data.");
                } else {
                    // Other error
                    header("Location: index.php?error=database&message=" . urlencode($e->getMessage()));
                }
                exit;
            }
        }

        header("Location: index.php");
        exit;
    }
}
