<?php
// getTasks.php
header('Access-Control-Allow-Origin: *');  // Adjust the origin as needed
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
 

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'sessionManager.php';

function jsonResponse($data, $statusCode = 200, $message = null)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');

    $response = array('status' => $statusCode);

    if ($message !== null) {
        $response['message'] = $message;
    }

    if ($statusCode >= 200 && $statusCode < 300) {
        $response['data'] = $data;
    } else {
        $response['error'] = $data;
    }

    echo json_encode($response);
    exit;
}

try {
    checkUserSession();

    $databaseFile = 'database.db'; // Veritabanı dosya adı
    $db = new SQLite3($databaseFile);

    if (isset($_SESSION['user'])) {
        $activeUserRole = $_SESSION['userRole'];
        $activeUserName = $_SESSION['user'];

        if ($activeUserName === 'admin') {
            // Admin ise
            $query = "SELECT id AS userId, task
                      FROM users
                      WHERE role = 'student'
                      ORDER BY id";
        } elseif ($activeUserRole === 'teacher') {
            // Öğretmen ise
            $query = "SELECT id AS userId, task
                      FROM users
                      WHERE teacher = :teacherName
                      ORDER BY id";
        }

        if (isset($query)) { // Check if $query is defined
            error_log("Query: $query"); // Log the query

            $resultStmt = $db->prepare($query);

            if ($activeUserRole === 'teacher') {
                $resultStmt->bindValue(':teacherName', $_SESSION['user'], SQLITE3_TEXT);
            }

            $result = $resultStmt->execute();

            $tasks = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $tasks[$row['userId']] = $row['task'];
            }

            // Veritabanı bağlantısını kapat
            $db->close();

            jsonResponse($tasks, 200, 'Tasks fetched successfully');
        } else {
            jsonResponse(null, 500, 'Internal Server Error: Query not defined');
        }
    } else {
        // Kullanıcı oturumu yoksa hata döndür
        jsonResponse(null, 401, 'Unauthorized');
    }
} catch (Exception $e) {
    // Log exception message
    error_log('Exception in getTasks.php: ' . $e->getMessage());
    jsonResponse(null, 500, 'Internal Server Error: ' . $e->getMessage());
}
?>
