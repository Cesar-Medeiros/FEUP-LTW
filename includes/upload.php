<?php 

function uploadImage($file, $folder, $filename){
    $errors = [];
    $path = '../resources/'.$folder.'/';
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];

    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];
    $file_size = $file['size'];
    $file_ext = strtolower(end(explode('.', $file['name'])));
    $file_name = $filename.'.'.$file_ext;

    $file = $path . $file_name;

    if (!in_array($file_ext, $extensions)) {
        $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
    }

    if ($file_size > 2*1024*1024) {
        $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
    }

    if (empty($errors)) {
        if(!move_uploaded_file($file_tmp, $file)){
            $errors[] = 'Error uploading file';
        }

        list($width, $height) = getimagesize($file);

        if($width > 200 && $height > 200){

        }

        $img200 = resize_image($file, 200, 200, FALSE);
        imagejpeg($img200, $path."medium/".$file_name);
    }

    if ($errors) print_r($errors);
}



function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

?>