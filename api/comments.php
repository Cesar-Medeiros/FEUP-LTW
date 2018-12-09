<?php 
    include_once '../database/db_msg.php';
    include_once 'api.php';


    $action = getAction();

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $action_array = getActionArray($action);
        $data = getResult($action_array);
        echo json_encode($data);
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST"){
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['message_id']) && isset($data['user_id']) && isset($data['text'])){
            addComment($data['message_id'], $data['user_id'], $data['text']);            
            http_response_code(200);
        }
        else{
            http_response_code(400);
        }
    }
    
    function getResult($action_array){
        list($type, $value) = each($action_array);
        switch($type){
            // case 'all': return getUsers();
            // case 'id' : return getComments($value);
            case 'message' : return getComments($value);
            default: http_response_code(400); die;
        }
    }
?>