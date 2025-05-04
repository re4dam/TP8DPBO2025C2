<?php
require_once 'controllers/wali_session.controller.php';

// Display messages if they exist
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
}
// if (isset($_GET['error'])) {
//     $errorMessage = htmlspecialchars($_GET['message'] ?? 'An error occurred');
//     echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
// }

$controller = new WaliSessionController();

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
