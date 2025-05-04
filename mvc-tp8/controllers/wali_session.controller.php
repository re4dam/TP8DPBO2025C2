<?php
require_once 'models/wali_session.class.php';
require_once 'models/student.class.php';
require_once 'models/lecturer.class.php';
require_once 'views/wali_session.view.php';

class WaliSessionController
{
    private $waliSession;
    private $student;
    private $lecturer;
    private $view;

    public function __construct()
    {
        $this->waliSession = new WaliSession();
        $this->student = new Student();
        $this->lecturer = new Lecturer();
        $this->view = new WaliSessionView('wali_session.php?action=');
    }

    public function index()
    {
        $waliSessions = $this->waliSession->getAllWaliSessions();
        $students = $this->student->getAllStudents();
        $lecturers = $this->lecturer->getAllLecturers();

        // format student data as id => name for the view
        $studentOptions = [];
        foreach ($students as $student) {
            $studentOptions[$student['id']] = $student['nama'];
        }

        // format lecturer data as id => name for the view
        $lecturerOptions = [];
        foreach ($lecturers as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        // render the list with relation data
        $this->view->renderWaliSessionList($waliSessions, $studentOptions, $lecturerOptions);
    }

    public function create()
    {
        $students = $this->student->getAllStudents();
        $lecturers = $this->lecturer->getAllLecturers();

        $studentOptions = [];
        foreach ($students as $student) {
            $studentOptions[$student['id']] = $student['nama'];
        }

        $lecturerOptions = [];
        foreach ($lecturers as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        if (isset($_POST['submit'])) {
            $id_student = $_POST['id_student'];
            $id_lecturer = $_POST['id_lecturer'];
            $tanggal = $_POST['tanggal'];
            $topik = $_POST['topik'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? '';

            $result = $this->waliSession->addWaliSession($id_student, $id_lecturer, $tanggal, $topik, $status, $catatan);
            if ($result) {
                header("Location: wali_session.php");
                exit;
            }
        }

        $this->view->renderWaliSessionForm(null, false, $studentOptions, $lecturerOptions);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: wali_session.php");
            exit;
        }

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $id_student = $_POST['id_student'];
            $id_lecturer = $_POST['id_lecturer'];
            $tanggal = $_POST['tanggal'];
            $topik = $_POST['topik'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? '';

            $result = $this->waliSession->updateWaliSession($id, $id_student, $id_lecturer, $tanggal, $topik, $status, $catatan);
            if ($result) {
                header("Location: wali_session.php");
                exit;
            }
        }

        // Get all students and lecturers for the dropdown
        $studentsData = $this->student->getAllStudents();
        $lecturersData = $this->lecturer->getAllLecturers();

        // Format student data as id => name for the view
        $studentOptions = [];
        foreach ($studentsData as $student) {
            $studentOptions[$student['id']] = $student['nama'];
        }

        // Format lecturer data as id => name for the view
        $lecturerOptions = [];
        foreach ($lecturersData as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        // get wali session data and display form
        $waliSession = $this->waliSession->getWaliSessionById($id);
        if ($waliSession) {
            $this->view->renderWaliSessionForm($waliSession, true, $studentOptions, $lecturerOptions);
        } else {
            header("Location: wali_session.php");
            exit;
        }
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $id_student = $_POST['id_student'];
            $id_lecturer = $_POST['id_lecturer'];
            $tanggal = $_POST['tanggal'];
            $topik = $_POST['topik'];
            $status = $_POST['status'];
            $catatan = $_POST['catatan'] ?? '';

            $result = $this->waliSession->updateWaliSession($id, $id_student, $id_lecturer, $tanggal, $topik, $status, $catatan);
            if ($result) {
                header("Location: wali_session.php");
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $result = $this->waliSession->deleteWaliSession($id);
                if ($result) {
                    header("Location: wali_session.php?message=Session+deleted+successfully");
                    exit;
                }
            } catch (PDOException $e) {
                // Check if it's a foreign key constraint violation
                if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
                    header("Location: wali_session.php?error=foreign_key&message=Cannot+delete+session.+It+is+referenced+in+other+records.");
                } else {
                    // Other database errors
                    header("Location: wali_session.php?error=database&message=" . urlencode($e->getMessage()));
                }
                exit;
            }
        }

        header("Location: wali_session.php");
        exit;
    }
}
