<?php
/**
 * Admin User Controller (Non-namespaced wrapper for admin routes)
 * Handles user creation and management for admin panel
 */

require_once __DIR__ . '/../config/dp.php';
require_once __DIR__ . '/../models/users.php';

class adminUserController {
    
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    /**
     * Store a new user
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return [
                'success' => false,
                'message' => 'Invalid request method',
                'code' => 405
            ];
        }

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $name = $_POST['name'] ?? null;
        $role = $_POST['role'] ?? 'user';
        $profilePicture = $this->handleAvatarUpload();

        // Validate input
        if (!$email || !$password || !$name) {
            return [
                'success' => false,
                'message' => 'Email, password, and name are required',
                'code' => 400
            ];
        }

        // Check if email already exists
        $existingUser = $this->user->getUserByEmail($email);
        if ($existingUser) {
            return [
                'success' => false,
                'message' => 'Email already exists',
                'code' => 400
            ];
        }

        try {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user using raw query (since the model might not have the insert method)
            $db = new db();
            $stmt = $db->connection->prepare("
                INSERT INTO users (email, password, name, role, profile_picture, room_no, ext, building, created_at, updated_at)
                VALUES (:email, :password, :name, :role, :profile_picture, :room_no, :ext, :building, NOW(), NOW())
            ");
            
            $result = $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword,
                ':name' => $name,
                ':role' => $role,
                ':profile_picture' => $profilePicture,
                ':room_no' => $_POST['room_no'] ?? null,
                ':ext' => $_POST['ext'] ?? null,
                ':building' => $_POST['building'] ?? null
            ]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'User created successfully',
                    'code' => 201
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to create user',
                    'code' => 500
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'code' => 500
            ];
        }
    }

    /**
     * Handle avatar upload
     */
    private function handleAvatarUpload() {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $_FILES['avatar']['error']);
        }

        $uploadDir = __DIR__ . '/../uploads/users/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . basename($_FILES['avatar']['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
            throw new Exception('Failed to move uploaded file');
        }

        return $fileName;
    }

    /**
     * Get all users
     */
    public function getAll() {
        try {
            $users = $this->user->getAllUsers();
            return [
                'success' => true,
                'data' => $users,
                'message' => 'Users retrieved successfully',
                'code' => 200
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'code' => 500
            ];
        }
    }

    /**
     * Delete a user
     */
    public function delete($id) {
        try {
            $db = new db();
            $stmt = $db->connection->prepare("DELETE FROM users WHERE id = :id");
            $result = $stmt->execute([':id' => $id]);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'User deleted successfully',
                    'code' => 200
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to delete user',
                    'code' => 500
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'code' => 500
            ];
        }
    }
}
?>
