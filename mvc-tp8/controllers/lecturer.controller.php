<?php
require_once 'models/lecturer.class.php';
require_once 'models/program_study.class.php';
require_once 'views/lecturer.view.php';

class LecturerController
{
    private $lecturer;
    private $programStudy;
    private $view;

    public function __construct()
    {
        $this->lecturer = new Lecturer();
        $this->programStudy = new ProgramStudy();
        $this->view = new LecturerView('lecturer.php?action=');
    }

    public function index()
    {
        $lecturers = $this->lecturer->getAllLecturers();
        $programStudies = $this->programStudy->getAllProgramStudies();

        // format program study data as id => name for the view
        $programStudyOptions = [];
        foreach ($programStudies as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama'];
        }

        // render the list with relation data
        $this->view->renderLecturerList($lecturers, $programStudyOptions);
    }

    public function create()
    {
        $programStudies = $this->programStudy->getAllProgramStudies();

        $programStudyOptions = [];
        foreach ($programStudies as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama'];
        }

        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $nip = $_POST['nip'];
            $phone = $_POST['phone'];
            $work_date = $_POST['work_date'];
            $join_date = $_POST['join_date'];
            $id_program_study = $_POST['id_program_study'];

            $result = $this->lecturer->addLecturer($nama, $nip, $phone, $work_date, $join_date, $id_program_study);
            if ($result) {
                header("Location: lecturer.php");
                exit;
            }
        }

        $this->view->renderLecturerForm(null, false, $programStudyOptions);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: lecturer.php");
            exit;
        }

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $nip = $_POST['nip'];
            $phone = $_POST['phone'];
            $work_date = $_POST['work_date'];
            $join_date = $_POST['join_date'];
            $id_program_study = $_POST['id_program_study'];

            $result = $this->lecturer->updateLecturer($id, $nama, $nip, $phone, $work_date, $join_date, $id_program_study);
            if ($result) {
                header("Location: lecturer.php");
                exit;
            }
        }

        // Get all program studies for the dropdown
        $programStudies = $this->programStudy->getAllProgramStudies();

        // Format program study data as id => name for the view
        $programStudyOptions = [];
        foreach ($programStudies as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama']; // Assuming 'name' is the display field
        }

        // get lecturer data and display form
        $lecturer = $this->lecturer->getLecturerById($id);
        if ($lecturer) {
            $this->view->renderLecturerForm($lecturer, true, $programStudyOptions);
        } else {
            header("Location: lecturer.php");
            exit;
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $result = $this->lecturer->deleteLecturer($id);
                if ($result) {
                    header("Location: lecturer.php?message=Lecturer+deleted+successfully");
                    exit;
                }
            } catch (PDOException $e) {
                // Check if it's a foreign key constraint violation
                if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
                    header("Location: lecturer.php?error=foreign_key&message=Cannot+delete+lecturer.+They+are+assigned+to+students.");
                } else {
                    // Other database errors
                    header("Location: lecturer.php?error=database&message=" . urlencode($e->getMessage()));
                }
                exit;
            }
        }

        header("Location: lecturer.php");
        exit;
    }
}
