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
                    addUser($data['username'], $data['password'], $data['email']);
                    http_response_code(200);
                }
                else{
                    echo json_encode(array('error' => 'Invalid Credentials'));
                    http_response_code(400);
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
                        echo json_encode(array('error' => 'Invalid Credentials'));
                        http_response_code(400);
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

<?php 
/*
function callHook() {
    global $url;
 
    $urlArray = array();
    $urlArray = explode("/",$url);
 
    $controller = $urlArray[0];
    array_shift($urlArray);
    $action = $urlArray[0];
    array_shift($urlArray);
    $queryString = $urlArray;
 
    $controllerName = $controller;
    $controller = ucwords($controller);
    $model = rtrim($controller, 's');
    $controller .= 'Controller';
    $dispatch = new $controller($model,$controllerName,$action);
 
    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch,$action),$queryString);
    } else {
    }
}
*/
?>