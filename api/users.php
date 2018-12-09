<?php 
    include_once '../database/db_user.php';
    include_once 'api.php';


    $action = getAction();

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $action_array = getActionArray($action);
        $data = getResult($action_array);
        echo json_encode($data);
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST"){
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['username']) && isset($data['password']) && isset($data['email'])){
            addUser($data['username'], $data['password'], $data['email']);
            http_response_code(200);
        }
        else{
            http_response_code(400);
        }
    }


    function getResult($action_array){
        list($type, $value) = each($action_array);
        switch($type){
            case 'all': return getUsers();
            case 'id' : return getUserById($value);
            case 'username' : return getUser($value);
            default: http_response_code(400); die;
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