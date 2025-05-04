<?php
require_once 'templates/Template.php';

abstract class BaseView
{
    protected $entityName;
    protected $actionBase;

    /**
     * Define the columns for the list view
     * Format: [
     *     ['field' => 'field_name', 'label' => 'Display Label', 'type' => 'text|date|etc' (optional)]
     * ]
     */
    abstract protected function getColumns();

    /**
     * Define the form fields for the create/edit view
     * Format: [
     *     [
     *         'name' => 'field_name', 
     *         'label' => 'Display Label', 
     *         'type' => 'text|date|email|number|select|etc', 
     *         'required' => true|false,
     *         'options' => [                // Required for select type
     *             ['value' => 'option_value', 'text' => 'Option Text'],
     *             ...
     *         ]
     *     ]
     * ]
     */
    abstract protected function getFormFields();

    /**
     * Constructor
     * 
     * @param string $entityName The name of the entity (e.g., 'Student', 'Course')
     * @param string $actionBase The base URL for actions (e.g., 'index.php?action=')
     */
    public function __construct($entityName, $actionBase = 'index.php?action=')
    {
        $this->entityName = $entityName;
        $this->actionBase = $actionBase;
    }

    /**
     * Render a list page for the entity
     * 
     * @param array $data Array of records to display
     * @param array $relationData Associative array of related data for displaying foreign keys
     * e.g. ['id_faculty' => ['1' => 'Engineering', '2' => 'Science']]
     */
    public function renderList($data, $relationData = [])
    {
        $no = 1;
        $dataRows = null;
        $tableHeaders = '';
        $columns = $this->getColumns();

        // Generate table headers based on columns
        $tableHeaders .= "<tr><th>NO</th>";
        foreach ($columns as $column) {
            $tableHeaders .= "<th>" . strtoupper($column['label']) . "</th>";
        }
        $tableHeaders .= "<th>ACTIONS</th></tr>";

        // Generate table rows
        foreach ($data as $row) {
            $dataRows .= "<tr class='text-center align-middle'><td>" . $no++ . "</td>";

            // Add data for each column
            foreach ($columns as $column) {
                $fieldName = $column['field'];
                $value = isset($row[$fieldName]) ? $row[$fieldName] : '';

                // Format based on type if specified
                if (isset($column['type'])) {
                    if ($column['type'] == 'date' && !empty($value)) {
                        // Format date if needed
                        $value = date('Y-m-d', strtotime($value));
                    }
                    // Handle foreign key display using relation data
                    elseif (
                        $column['type'] == 'foreign_key' &&
                        isset($relationData[$fieldName]) &&
                        is_array($relationData[$fieldName]) &&
                        isset($relationData[$fieldName][$value])
                    ) {
                        $value = $relationData[$fieldName][$value];
                    }
                }

                $dataRows .= "<td>" . $value . "</td>";
            }

            // Add action buttons
            $dataRows .= "<td>
                <a href='" . $this->actionBase . "edit&id=" . $row['id'] . "' class='btn btn-warning mb-2 mb-md-0'>Edit</a>
                <a href='" . $this->actionBase . "delete&id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </td></tr>";
        }

        $tpl = new Template("templates/list.html");
        $tpl->replace("JUDUL", $this->entityName . " List");
        $tpl->replace("ENTITY_NAME", $this->entityName);
        $tpl->replace("TABLE_HEADERS", $tableHeaders);
        $tpl->replace("DATA_TABEL", $dataRows ?? "<tr><td colspan='" . (count($columns) + 2) . "' class='text-center'>No data available</td></tr>");
        $tpl->replace("ACTION_BASE", $this->actionBase);
        $tpl->write();
    }

    /**
     * Render a form page for the entity
     * 
     * @param array|null $data Data for the form (for edit mode)
     * @param bool $isEdit Whether this is an edit form
     * @param array $relationData Associative array of related data for dropdowns
     *                            e.g. ['id_faculty' => ['1' => 'Engineering', '2' => 'Science']]
     */
    public function renderForm($data = null, $isEdit = false, $relationData = [])
    {
        // Ensure $data is an array or null
        if ($data !== null && !is_array($data)) {
            $data = null;
            $isEdit = false;
        }

        $title = $isEdit ? "Edit $this->entityName" : "Add New $this->entityName";
        $id = ($isEdit && $data !== null && isset($data['id'])) ? $data['id'] : "";
        $formInputs = "";
        $formFields = $this->getFormFields();

        // Generate form fields
        foreach ($formFields as $field) {
            if (!isset($field['name']) || !isset($field['label'])) {
                continue; // Skip malformed field definitions
            }

            $fieldName = $field['name'];
            $fieldLabel = $field['label'];
            $fieldType = isset($field['type']) ? $field['type'] : 'text';
            $required = isset($field['required']) && $field['required'] ? 'required' : '';

            // Safely get value
            $value = '';
            if ($isEdit && $data !== null && is_array($data) && isset($data[$fieldName])) {
                $value = $data[$fieldName];
            }

            // Handle different field types
            if ($fieldType === 'textarea') {
                $formInputs .= "
                <div class='mb-3'>
                    <label for='$fieldName' class='form-label'>" . strtoupper($fieldLabel) . ":</label>
                    <textarea id='$fieldName' name='$fieldName' class='form-control' $required>$value</textarea>
                </div>";
            }
            // Handle select/dropdown fields
            elseif ($fieldType === 'select') {
                $options = '';

                // Get options from relationData if field is a foreign key
                if (isset($relationData[$fieldName]) && is_array($relationData[$fieldName])) {
                    foreach ($relationData[$fieldName] as $optionValue => $optionText) {
                        $selected = ($value == $optionValue) ? 'selected' : '';
                        $options .= "<option value='$optionValue' $selected>$optionText</option>";
                    }
                }
                // Or use provided options in field definition
                elseif (isset($field['options']) && is_array($field['options'])) {
                    foreach ($field['options'] as $option) {
                        if (!isset($option['value']) || !isset($option['text'])) {
                            // continue; // Skip malformed option
                        }
                        $optionValue = $option;
                        $optionText = $option;
                        $selected = ($value == $optionValue) ? 'selected' : '';
                        $options .= "<option value='$optionValue' $selected>$optionText</option>";
                    }
                }

                $formInputs .= "
                <div class='mb-3'>
                    <label for='$fieldName' class='form-label'>" . strtoupper($fieldLabel) . ":</label>
                    <select id='$fieldName' name='$fieldName' class='form-control' $required>
                        <option value=''>Select " . $fieldLabel . "</option>
                        $options
                    </select>
                </div>";
            }
            // Default to regular input fields
            else {
                $formInputs .= "
                <div class='mb-3'>
                    <label for='$fieldName' class='form-label'>" . strtoupper($fieldLabel) . ":</label>
                    <input type='$fieldType' id='$fieldName' name='$fieldName' value='$value' class='form-control' $required>
                </div>";
            }
        }

        $tpl = new Template("templates/form.html");
        $tpl->replace("JUDUL", $title);
        $tpl->replace("ENTITY_NAME", $this->entityName);
        $tpl->replace("FORM_ACTION", $isEdit ? $this->actionBase . "edit&id=$id" : $this->actionBase . "create");
        $tpl->replace("HEADER_CLASS", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("HEADER_TEXT", $isEdit ? "Update $this->entityName" : "Create $this->entityName");
        $tpl->replace("FORM_FIELDS", $formInputs);
        $tpl->replace("HIDDEN_ID", $isEdit ? "<input type='hidden' name='id' value='$id'>" : "");
        $tpl->write();
    }
}
