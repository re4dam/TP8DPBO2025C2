<?php
require_once 'base.view.php';

class ProgramStudyView extends BaseView
{
    /**
     * Constructor
     * 
     * @param string $actionBase The base URL for actions
     */
    public function __construct($actionBase = 'prodi.php?action=')
    {
        parent::__construct('Program Study', $actionBase);
    }

    /**
     * Define the columns for the program study list view
     */
    protected function getColumns()
    {
        return [
            ['field' => 'nama', 'label' => 'Nama'],
            ['field' => 'kode', 'label' => 'Kode'],
            ['field' => 'id_faculty', 'label' => 'Faculty', 'type' => 'foreign_key'],
        ];
    }

    /**
     * Define the form fields for the program study form
     */
    protected function getFormFields()
    {
        return [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'required' => true],
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text', 'required' => true],
            ['name' => 'id_faculty', 'label' => 'Faculty', 'type' => 'select', 'required' => true],
        ];
    }

    /**
     * Render the program study list with faculty data
     * 
     * @param array $data Array of program study records
     * @param array $facultyData Array of faculty records [id => name]
     */
    public function renderProgramStudyList($data, $facultyData)
    {
        // Prepare relation data for faculty dropdown
        $relationData = [
            'id_faculty' => $facultyData
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
    public function renderProgramStudyForm($data = null, $isEdit = false, $facultyData = [])
    {
        // Prepare relation data for faculty dropdown
        $relationData = [
            'id_faculty' => $facultyData
        ];

        // Call parent method with relation data
        parent::renderForm($data, $isEdit, $relationData);
    }
}
