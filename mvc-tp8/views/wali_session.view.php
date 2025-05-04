<?php
require_once 'base.view.php';

class WaliSessionView extends BaseView
{
    /**
     * Constructor
     * 
     * @param string $actionBase The base URL for actions
     */
    public function __construct($actionBase = 'wali_session.php?action=')
    {
        parent::__construct('Wali Session', $actionBase);
    }

    /**
     * Define the columns for the wali session list view
     */
    protected function getColumns()
    {
        return [
            ['field' => 'id_student', 'label' => 'Student', 'type' => 'foreign_key'],
            ['field' => 'id_lecturer', 'label' => 'Lecturer', 'type' => 'foreign_key'],
            ['field' => 'tanggal', 'label' => 'Date'],
            ['field' => 'topik', 'label' => 'Topic'],
            ['field' => 'status', 'label' => 'Status'],
            ['field' => 'catatan', 'label' => 'Notes'],
        ];
    }

    /**
     * Define the form fields for the wali session form
     */
    protected function getFormFields()
    {
        return [
            ['name' => 'id_student', 'label' => 'Student', 'type' => 'select', 'required' => true],
            ['name' => 'id_lecturer', 'label' => 'Lecturer', 'type' => 'select', 'required' => true],
            ['name' => 'tanggal', 'label' => 'Date', 'type' => 'date', 'required' => true],
            ['name' => 'topik', 'label' => 'Topic', 'type' => 'text', 'required' => true],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'required' => true,
                'options' => ['scheduled', 'done', 'cancelled']
            ],
            ['name' => 'catatan', 'label' => 'Notes', 'type' => 'textarea', 'required' => false],
        ];
    }

    /**
     * Render the wali session list with student and lecturer data
     * 
     * @param array $data Array of wali session records
     * @param array $studentData Array of student records [id => name]
     * @param array $lecturerData Array of lecturer records [id => name]
     */
    public function renderWaliSessionList($data, $studentData, $lecturerData)
    {
        // Prepare relation data for student and lecturer dropdowns
        $relationData = [
            'id_student' => $studentData,
            'id_lecturer' => $lecturerData
        ];

        // Call parent method with relation data
        parent::renderList($data, $relationData);
    }

    /**
     * Render the wali session form with student and lecturer dropdowns
     * 
     * @param array $data Data for the form (for edit mode)
     * @param bool $isEdit Whether this is an edit form
     * @param array $studentData Array of student records [id => name]
     * @param array $lecturerData Array of lecturer records [id => name]
     */
    public function renderWaliSessionForm($data = null, $isEdit = false, $studentData = [], $lecturerData = [])
    {
        // Prepare relation data for student and lecturer dropdowns
        $relationData = [
            'id_student' => $studentData,
            'id_lecturer' => $lecturerData
        ];

        // Call parent method with relation data
        parent::renderForm($data, $isEdit, $relationData);
    }
}
