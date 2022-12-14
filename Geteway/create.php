<?php 

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: POST");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Instance = Database::getInstance();
    $database = $Instance->getConnetion();
    $products = new Products($database);

    $data = json_decode(file_get_contents("php://input"));
  
    if (!empty($data->nom) && !empty($data->description) && !empty($data->prix) && !empty($data->categories_id)){
        $products->name  =  $data->nom;
        $products->description = $data->description;
        $products->price = $data->prix;
        $products->category_id=$data->categories_id;
        $result = $products->create();
       
        if($result == true){

            http_response_code(201);
            echo json_encode([
                "message" => "L'ajout a été effectué"
            ], JSON_UNESCAPED_UNICODE);

        }else{

            http_response_code(503);
            echo json_encode([
                "message" => "L'ajout a echouée"
            ], JSON_UNESCAPED_UNICODE);

        }  

    }else{
        http_response_code(404);
            echo json_encode([
                "message" => "les informations a poster sont vide"
            ], JSON_UNESCAPED_UNICODE);
    }
}