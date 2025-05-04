<?php
require_once 'views/base.view.php';

class FacultyView extends BaseView
{
    /**
     * Constructor
     * 
     * @param string $actionBase The base URL for actions
     */
    public function __construct($actionBase = 'index.php?action=')
    {
        parent::__construct('Faculty', $actionBase);
    }

    /**
     * Define the columns for the student list view
     */
    protected function getColumns()
    {
        return [
            ['field' => 'nama', 'label' => 'Nama'],
            ['field' => 'kode', 'label' => 'Kode'],
        ];
    }

    /**
     * Define the form fields for the student form
     */
    protected function getFormFields()
    {
        return [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'required' => true],
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text', 'required' => true],
        ];
    }
}
