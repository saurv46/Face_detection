<?php

$conn = new mysqli('localhost', 'root', '', 'face_auth');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $faceDescriptor = $conn->real_escape_string($_POST['faceDescriptor']);
    $image = $_FILES['image'];

   
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
      echo $faceDescriptor;
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
       
        $sql = "INSERT INTO users (username, image_path, face_descriptor) VALUES ('$username', '$targetFile', '$faceDescriptor')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

$conn->close();
?>
