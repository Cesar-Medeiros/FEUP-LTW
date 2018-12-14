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

            case 'id':
                $data = getCommentWithInfo($value);
                break;

            case 'message' : 
                $data = getCommentsWithInfo($value);
                break;

            default: http_response_code(400); die();
        }

        echo json_encode($data);
        http_response_code(200);
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST"){
        $dataR = json_decode(file_get_contents('php://input'), true);

        switch($type){
            case 'all': {
                if(isset($dataR['message_id']) && isset($dataR['text'])){
                    $comment_id = addComment($dataR['message_id'], $_SESSION['user_id'], $dataR['text']);
                    $data = getCommentWithInfo($comment_id);
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