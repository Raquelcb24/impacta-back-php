<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php'; //necesito utilizar el documento donde tengo los datos de mi base de datos

// Obtengo los datos del formulario
$data = json_decode(file_get_contents("php://input"));

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
  
//INSERT INTO  a mi db SQL 

  $sql = "INSERT INTO formData (name, email, phone, planet, message, radio, privacy) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssi", $name, $email, $phone, $planet, $message, $radio, $privacy); //ssssssi formatos de mis values (string, int)

  if ($stmt->execute()) { //ejecutar la consulta anterior
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false]);
  }

  $stmt->close();
} else {
  echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conn->close();
?>
