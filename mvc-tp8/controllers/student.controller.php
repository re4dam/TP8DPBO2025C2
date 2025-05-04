<?php
require_once 'models/student.class.php';
require_once 'models/program_study.class.php';
require_once 'models/lecturer.class.php';
require_once 'views/student.view.php';

class StudentController
{
    private $student;
    private $programStudy;
    private $lecturer;
    private $view;

    public function __construct()
    {
        $this->student = new Student();
        $this->programStudy = new ProgramStudy();
        $this->lecturer = new Lecturer();
        $this->view = new StudentView('student.php?action=');
    }

    public function index()
    {
        $students = $this->student->getAllStudents();
        $programStudies = $this->programStudy->getAllProgramStudies();
        $lecturers = $this->lecturer->getAllLecturers();

        // format program study data as id => name for the view
        $programStudyOptions = [];
        foreach ($programStudies as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama'];
        }

        // format lecturer data as id => name for the view
        $lecturerOptions = [];
        foreach ($lecturers as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        // render the list with relation data
        $this->view->renderStudentList($students, $programStudyOptions, $lecturerOptions);
    }

    public function create()
    {
        $programStudies = $this->programStudy->getAllProgramStudies();
        $lecturers = $this->lecturer->getAllLecturers();

        $programStudyOptions = [];
        foreach ($programStudies as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama'];
        }

        $lecturerOptions = [];
        foreach ($lecturers as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $nim = $_POST['nim'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];
            $address = $_POST['address'];
            $angkatan = $_POST['angkatan'];
            $id_program_study = $_POST['id_program_study'];
            $id_lecturer = $_POST['id_lecturer'];

            $result = $this->student->addStudent($nama, $nim, $gender, $phone, $email, $birth_date, $address, $angkatan, $id_program_study, $id_lecturer);
            if ($result) {
                header("Location: student.php");
                exit;
            }
        }

        $this->view->renderStudentForm(null, false, $programStudyOptions, $lecturerOptions);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: student.php");
            exit;
        }

        // if form is submitted
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $nim = $_POST['nim'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];
            $address = $_POST['address'];
            $angkatan = $_POST['angkatan'];
            $id_program_study = $_POST['id_program_study'];
            $id_lecturer = $_POST['id_lecturer'];

            $result = $this->student->updateStudent($id, $nama, $nim, $gender, $phone, $email, $birth_date, $address, $angkatan, $id_program_study, $id_lecturer);
            if ($result) {
                header("Location: student.php");
                exit;
            }
        }

        // Get all program studies for the dropdown
        $programStudiesData = $this->programStudy->getAllProgramStudies();
        $lecturersData = $this->lecturer->getAllLecturers();

        // Format program study data as id => name for the view
        $programStudyOptions = [];
        foreach ($programStudiesData as $programStudy) {
            $programStudyOptions[$programStudy['id']] = $programStudy['nama'];
        }

        // Format lecturer data as id => name for the view
        $lecturerOptions = [];
        foreach ($lecturersData as $lecturer) {
            $lecturerOptions[$lecturer['id']] = $lecturer['nama'];
        }

        // get student data and display form
        $student = $this->student->getStudentById($id);
        if ($student) {
            $this->view->renderStudentForm($student, true, $programStudyOptions, $lecturerOptions);
        } else {
            header("Location: student.php");
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
            $nim = $_POST['nim'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];
            $address = $_POST['address'];
            $angkatan = $_POST['angkatan'];
            $id_program_study = $_POST['id_program_study'];
            $id_lecturer = $_POST['id_lecturer'];

            $result = $this->student->updateStudent($id, $nama, $nim, $gender, $phone, $email, $birth_date, $address, $angkatan, $id_program_study, $id_lecturer);
            if ($result) {
                header("Location: student.php");
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $result = $this->student->deleteStudent($id);
                if ($result) {
                    header("Location: student.php?message=Student+deleted+successfully");
                    exit;
                }
            } catch (PDOException $e) {
                // Check if it's a foreign key constraint violation
                if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
                    header("Location: student.php?error=foreign_key&message=Cannot+delete+student.+The+student+is+referenced+in+other+records.");
                } else {
                    // Other database errors
                    header("Location: student.php?error=database&message=" . urlencode($e->getMessage()));
                }
                exit;
            }
        }

        header("Location: student.php");
        exit;
    }
}
