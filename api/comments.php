<?php 
    include_once('../database/db_msg.php');
    include_once('../includes/session.php');
    include_once('api.php');

    header('Content-Type: application/json');

    $action = getAction();
    $action_array = getActionArray($action);
    list($type, $value) = each($action_array);

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        switch($type){
            case 'message' : 
                $data = getComments($value);
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
                if(isset($data['message_id']) && isset($data['text'])){
                    $comment_id = addComment($data['message_id'], $_SESSION['user_id'], $data['text']);  
                    $data = getMessage($comment_id); 
                    http_response_code(200);
                }
                else{
                    http_response_code(400);
                }
                break;
            }
            default: http_response_code(400); die();
        }

        echo json_encode($data);
        http_response_code(200);
    }
?>