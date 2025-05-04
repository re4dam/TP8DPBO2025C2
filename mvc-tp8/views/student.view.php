<?php
require_once 'base.view.php';

class StudentView extends BaseView
{
    /**
     * Constructor
     * 
     * @param string $actionBase The base URL for actions
     */
    public function __construct($actionBase = 'student.php?action=')
    {
        parent::__construct('Student', $actionBase);
    }

    /**
     * Define the columns for the student list view
     */
    protected function getColumns()
    {
        return [
            ['field' => 'nama', 'label' => 'Name'],
            ['field' => 'nim', 'label' => 'NIM'],
            ['field' => 'gender', 'label' => 'Gender'],
            ['field' => 'email', 'label' => 'Email'],
            ['field' => 'phone', 'label' => 'Phone'],
            ['field' => 'birth_date', 'label' => 'Birth Date'],
            ['field' => 'address', 'label' => 'Address'],
            ['field' => 'angkatan', 'label' => 'Year'],
            ['field' => 'id_program_study', 'label' => 'Program Study', 'type' => 'foreign_key'],
            ['field' => 'id_lecturer', 'label' => 'Lecturer', 'type' => 'foreign_key'],
        ];
    }

    /**
     * Define the form fields for the student form
     */
    protected function getFormFields()
    {
        return [
            ['name' => 'nama', 'label' => 'Name', 'type' => 'text', 'required' => true],
            ['name' => 'nim', 'label' => 'NIM', 'type' => 'text', 'required' => true],
            [
                'name' => 'gender',
                'label' => 'Gender',
                'type' => 'select',
                'required' => true,
                'options' => ['Male', 'Female']
            ],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['name' => 'phone', 'label' => 'Phone Number', 'type' => 'text', 'required' => true],
            ['name' => 'birth_date', 'label' => 'Birth Date', 'type' => 'date', 'required' => true],
            ['name' => 'address', 'label' => 'Address', 'type' => 'textarea', 'required' => true],
            ['name' => 'angkatan', 'label' => 'Year', 'type' => 'number', 'required' => true],
            ['name' => 'id_program_study', 'label' => 'Program Study', 'type' => 'select', 'required' => true],
            ['name' => 'id_lecturer', 'label' => 'Lecturer', 'type' => 'select', 'required' => true],
        ];
    }

    /**
     * Render the student list with program study and lecturer data
     * 
     * @param array $data Array of student records
     * @param array $programStudyData Array of program study records [id => name]
     * @param array $lecturerData Array of lecturer records [id => name]
     */
    public function renderStudentList($data, $programStudyData, $lecturerData = [])
    {
        // Prepare relation data for program study and lecturer dropdowns
        $relationData = [
            'id_program_study' => $programStudyData,
            'id_lecturer' => $lecturerData
        ];

        // Call parent method with relation data
        parent::renderList($data, $relationData);
    }

    /**
     * Render the student form with program study and lecturer dropdowns
     * 
     * @param array $data Data for the form (for edit mode)
     * @param bool $isEdit Whether this is an edit form
     * @param array $programStudyData Array of program study records [id => name]
     * @param array $lecturerData Array of lecturer records [id => name]
     */
    public function renderStudentForm($data = null, $isEdit = false, $programStudyData = [], $lecturerData = [])
    {
        // Prepare relation data for program study and lecturer dropdowns
        $relationData = [
            'id_program_study' => $programStudyData,
            'id_lecturer' => $lecturerData
        ];

        // Call parent method with relation data
        parent::renderForm($data, $isEdit, $relationData);
    }
}
