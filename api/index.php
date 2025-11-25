<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'config/database.php';
require_once 'models/Company.php';

$database = new Database();
$db = $database->getConnection();
$company = new Company($db);

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

// Parse ID dari URL jika ada
$uri_parts = explode('/', trim(parse_url($request_uri, PHP_URL_PATH), '/'));
$id = isset($uri_parts[count($uri_parts) - 1]) && is_numeric($uri_parts[count($uri_parts) - 1]) 
     ? $uri_parts[count($uri_parts) - 1] 
     : null;

switch($method) {
    case 'GET':
        if($id) {
            // GET single company by ID
            $company->id = $id;
            $result = $company->readOne();
            
            if($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Company not found."));
            }
        } else {
            // GET all companies
            $stmt = $company->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $companies_arr = array();
                $companies_arr["records"] = array();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $company_item = array(
                        "id" => $id,
                        "name" => $name,
                        "category" => $category,
                        "description" => $description,
                        "image_url" => $image_url,
                        "founded_year" => $founded_year,
                        "employees" => $employees,
                        "website" => $website,
                        "created_at" => $created_at
                    );
                    array_push($companies_arr["records"], $company_item);
                }
                
                http_response_code(200);
                echo json_encode($companies_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "No companies found."));
            }
        }
        break;
        
    case 'POST':
        // CREATE new company
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->name) && !empty($data->category) && !empty($data->description)) {
            $company->name = $data->name;
            $company->category = $data->category;
            $company->description = $data->description;
            $company->image_url = $data->image_url ?? '';
            $company->founded_year = $data->founded_year ?? 0;
            $company->employees = $data->employees ?? 0;
            $company->website = $data->website ?? '';
            
            if($company->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Company was created successfully."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create company."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create company. Data is incomplete."));
        }
        break;
        
    case 'PUT':
        // UPDATE existing company
        $data = json_decode(file_get_contents("php://input"));
        
        if($id && !empty($data->name)) {
            $company->id = $id;
            $company->name = $data->name;
            $company->category = $data->category ?? '';
            $company->description = $data->description ?? '';
            $company->image_url = $data->image_url ?? '';
            $company->founded_year = $data->founded_year ?? 0;
            $company->employees = $data->employees ?? 0;
            $company->website = $data->website ?? '';
            
            if($company->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Company was updated successfully."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update company."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update company. Data is incomplete."));
        }
        break;
        
    case 'DELETE':
        // DELETE company
        if($id) {
            $company->id = $id;
            
            if($company->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Company was deleted successfully."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete company."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to delete company. ID is missing."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>