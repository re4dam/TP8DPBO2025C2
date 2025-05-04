<?php
require_once 'controllers/faculty.controller.php';

$controller = new FacultyController();

// Display messages if they exist
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
// if (isset($_GET['error'])) {
//     $errorMessage = htmlspecialchars($_GET['message'] ?? 'An error occurred');
//     echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
// }

// Route the request
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
