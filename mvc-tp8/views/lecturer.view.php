<?php
require_once 'base.view.php';

class LecturerView extends BaseView
{
    /**
     * Constructor
     *
     * @param string $actionBase the base URL for actions
     */
    public function __construct($actionBase = '')
    {
        parent::__construct('Lecturer', $actionBase);
    }

    protected function getColumns()
    {
        return [
            ['field' => 'nama', 'label' => 'Nama'],
            ['field' => 'nip', 'label' => 'NIP'],
            ['field' => 'phone', 'label' => 'Phone'],
            ['field' => 'work_date', 'label' => 'Work Date', 'type' => 'date'],
            ['field' => 'join_date', 'label' => 'Join Date', 'type' => 'date'],
            ['field' => 'id_program_study', 'label' => 'Program Study', 'type' => 'foreign_key'],
        ];
    }

    protected function getFormFields()
    {
        return [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'required' => true],
            ['name' => 'nip', 'label' => 'NIP', 'type' => 'text', 'required' => true],
            ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'required' => true],
            ['name' => 'work_date', 'label' => 'Work Date', 'type' => 'date', 'required' => true],
            ['name' => 'join_date', 'label' => 'Join Date', 'type' => 'date', 'required' => true],
            ['name' => 'id_program_study', 'label' => 'Program Study', 'type' => 'select', 'required' => true],
        ];
    }

    /**
     * Render the program study list with faculty data
     * 
     * @param array $data Array of program study records
     * @param array $facultyData Array of faculty records [id => name]
     */
    public function renderLecturerList($data, $programStudyData)
    {
        // Prepare relation data for faculty dropdown
        $relationData = [
            'id_program_study' => $programStudyData
        ];

        // Call parent method with relation data
        parent::renderList($data, $relationData);
    }

    /**
     * Render the program study form with faculty dropdown
     * 
     * @param array $data Data for the form (for edit mode)
     * @param bool $isEdit Whether this is an edit form
     * @param array $facultyData Array of faculty records [id => name]
     */
    public function renderLecturerForm($data = null, $isEdit = false, $programStudyData = [])
    {
        // Prepare relation data for faculty dropdown
        $relationData = [
            'id_program_study' => $programStudyData
        ];

        // Call parent method with relation data
        parent::renderForm($data, $isEdit, $relationData);
    }
}
