<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type");

require 'db.php';

// Obtengo los datos del formulario
$data = json_decode(file_get_contents("php://input"));

// Guardo los datos que recibo para ver si se están enviando correctamente
file_put_contents('log.txt', print_r($data, true));

// conpruebo si los datos están completos
if (
  isset($data->name) &&
  isset($data->email) &&
  isset($data->message) &&
  isset($data->privacy)
) {
  $name = $data->name;
  $email = $data->email;
  $phone = isset($data->phone) ? $data->phone : '';
  $planet = isset($data->planet) ? $data->planet : '';
  $message = $data->message;
  $radio = isset($data->radio) ? $data->radio : '';
  $privacy = $data->privacy;
  
  // insert into a la base de datos
  $sql = "INSERT INTO formData (name, email, phone, planet, message, radio, privacy) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]);
    exit();
  }

  $stmt->bind_param("ssssssi", $name, $email, $phone, $planet, $message, $radio, $privacy);

  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "message" => "Error en la ejecución de la consulta: " . $stmt->error]);
  }

  $stmt->close();
} else {
  echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conn->close();
?>
