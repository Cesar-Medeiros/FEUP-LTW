<?php 

    function getAction(){
        
        $url_array = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($url_array);  //Remove null
        array_shift($url_array);  //Remove /api
        array_shift($url_array);  //Remove /users
        return $url_array;
    }

    function getActionArray($action){
        if(empty($action)) return array('all' => '');
        else if(ctype_digit($action[0])) return array('id' => $action[0]);
        else if(isset($action[1])) return array($action[0] => $action[1]);
        else return array($action[0] => '');
    }
?>