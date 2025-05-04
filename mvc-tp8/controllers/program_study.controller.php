<?php
require_once 'models/program_study.class.php';
require_once 'models/faculty.class.php';
require_once 'views/program_study.view.php';

class ProgramStudyController
{
    private $programStudy;
    private $faculty;
    private $view;

    public function __construct()
    {
        $this->programStudy = new ProgramStudy();
        $this->faculty = new Faculty();
        $this->view = new ProgramStudyView('prodi.php?action=');
    }

    public function index()
    {
        $programStudies = $this->programStudy->getAllProgramStudies();
        $faculties = $this->faculty->getAllFaculties();

        // format faculty data as id => name for the view
        $facultyOptions = [];
        foreach ($faculties as $faculty) {
            $facultyOptions[$faculty['id']] = $faculty['nama'];
        }

        // render the list with relation data
        $this->view->renderProgramStudyList($programStudies, $facultyOptions);
    }

    public function create()
    {
        $faculties = $this->faculty->getAllFaculties();

        $facultyOptions = [];
        foreach ($faculties as $faculty) {
            $facultyOptions[$faculty['id']] = $faculty['nama'];
        }

        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $kode = $_POST['kode'];
            $id_faculty = $_POST['id_faculty'];

            $result = $this->programStudy->addProgramStudy($nama, $kode, $id_faculty);
            if ($result) {
                header("Location: prodi.php");
                exit;
            }
        }

        $this->view->renderProgramStudyForm(null, false, $facultyOptions);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: prodi.php");
            exit;
        }

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $kode = $_POST['kode'];
            $id_faculty = $_POST['id_faculty'];

            $result = $this->programStudy->updateProgramStudy($id, $nama, $kode, $id_faculty);
            if ($result) {
                header("Location: prodi.php");
                exit;
            }
        }

        // Get all faculties for the dropdown
        $facultiesData = $this->faculty->getAllFaculties();

        // Format faculty data as id => name for the view
        $facultyOptions = [];
        foreach ($facultiesData as $faculty) {
            $facultyOptions[$faculty['id']] = $faculty['nama']; // Assuming 'name' is the display field
        }

        // get student data and display form
        $program_study = $this->programStudy->getProgramStudyById($id);
        if ($program_study) {
            $this->view->renderProgramStudyForm($program_study, true, $facultyOptions);
        } else {
            header("Location: prodi.php");
            exit;
        }
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $kode = $_POST['kode'];
            $id_faculty = $_POST['id_faculty'];

            $result = $this->programStudy->updateProgramStudy($id, $nama, $kode, $id_faculty);
            if ($result) {
                header("Location: prodi.php");
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $result = $this->programStudy->deleteProgramStudy($id);
                if ($result) {
                    header("Location: prodi.php?message=Program+study+deleted+successfully");
                    exit;
                }
            } catch (PDOException $e) {
                // Check if it's a foreign key constraint violation
                if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
                    header("Location: prodi.php?error=foreign_key&message=Cannot+delete+program+study.+It+is+being+referenced+by+student+data.");
                } else {
                    // Other database errors
                    header("Location: prodi.php?error=database&message=" . urlencode($e->getMessage()));
                }
                exit;
            }
        }

        header("Location: prodi.php");
        exit;
    }
}
