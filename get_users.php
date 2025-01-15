<?php
header('Content-Type: application/json');


$conn = new mysqli('localhost', 'root', '', 'face_auth');
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}


$sql = "SELECT username, face_descriptor FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $descriptor = json_decode($row['face_descriptor']);
       
        $usern = $row['username'];
        // echo $usern . "\n";
        
      
        $users[] = [
            'username' => $row['username'],
            'descriptor' => $descriptor,
        ];
    }
}

$conn->close();
echo json_encode($users); 
// print_r($users);
?>
