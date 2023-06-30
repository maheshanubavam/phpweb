<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// User data for deletion and addition
$userIdToDelete = 123;
$newUser = [
    'name' => 'John Doe',
    'email' => 'johndoe@example.com',
    'age' => 25
];

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user with specified ID exists and delete if found
    $deleteStatement = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $deleteStatement->execute([$userIdToDelete]);

    if ($deleteStatement->rowCount() > 0) {
        // User exists, perform deletion
        $deleteStatement = $conn->prepare("DELETE FROM users WHERE id = ?");
        $deleteStatement->execute([$userIdToDelete]);

        echo "User with ID $userIdToDelete deleted successfully.<br>";
    } else {
        echo "User with ID $userIdToDelete not found.<br>";
    }

    // Check if user with specified email already exists
    $existingUserStatement = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $existingUserStatement->execute([$newUser['email']]);

    if ($existingUserStatement->rowCount() > 0) {
        echo "User with email {$newUser['email']} already exists.<br>";
    } else {
        // Add new user
        $addUserStatement = $conn->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
        $addUserStatement->execute([$newUser['name'], $newUser['email'], $newUser['age']]);

        echo "User added successfully.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
