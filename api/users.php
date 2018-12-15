<?php 
    include_once('../database/db_user.php');
    include_once('../includes/session.php');
    include_once('api.php');

    header('Content-Type: application/json');

    $action = getAction();
    $action_array = getActionArray($action);
    list($type, $value) = each($action_array);

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        switch($type){
            case 'all': 
                $data =  getUsers(); 
                break;

            case 'id':
                $data = getUserById($value);
                break;
                
            case 'username': 
                $data =  getUser($value); 
                break;

            default: http_response_code(400); die();
        }

        echo json_encode($data);
        http_response_code(200);
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST"){
        $data = json_decode(file_get_contents('php://input'), true);

        switch($type){
            case 'all': {
                if(isset($data['username']) && isset($data['password']) && isset($data['email'])){
                    try {
                        addUser($data['username'], $data['password'], $data['email']);
                    } catch (PDOException $e) {
                        http_response_code(400);
                        echo json_encode(array('error' => 'Invalid Credentials'));
                        die();
                    }
                    http_response_code(200);
                }
                else{
                    http_response_code(400);
                    echo json_encode(array('error' => 'Fill all fields'));
                }
                break;
            }
            case 'login' : {
                if(isset($data['username']) && isset($data['password'])){
                    if(checkUserPassword($data['username'], $data['password'])){
                        $user_id = getUser($data['username'])['user_id'];
                        $_SESSION['user_id'] = $user_id;
                        http_response_code(200);
                    }
                    else{
                        http_response_code(400);
                        echo json_encode(array('error' => 'Invalid Credentials'));
                    }
                }
                else{
                    http_response_code(400);
                }
                break;
            }

            default: http_response_code(400); die();
        }
    }
?>