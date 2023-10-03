<?php
include "config.php";
//get there values which are sent from ajax to php
$og_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
$full_url = str_replace(' ','', $og_url); //removing soace fromn url entered
$hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

if(!empty($full_url)){
    $domain = "localhost";

   //check user have edited or remove domain name or not
   if(preg_match("/{$domain}/i", $full_url) && preg_match("/\//i", $full_url)){
    $explodeURL = explode('/',$full_url);
    $short_url = end($explodeURL); //getting last value of full url

    if($short_url != ""){
        //select randomly created url to update with user entered new value
        $sql = mysqli_query($conn,"SELECT shorten_url FROM url WHERE shorten_url = '{$short_url}' && shorten_url != '{$hidden_url}'");
        
        if(mysqli_num_rows($sql) == 0) { // if the user entered url not exist in our db
            //update link or url
            $sql2 = mysqli_query($conn,"UPDATE url SET shorten_url='{$short_url}' WHERE shorten_url = '{$hidden_url}'");
            if($sql2){ //if url updated
                echo 'success';
            }else{
                echo 'Error-Sth went wrong';
            }
        }else {
            echo 'Error-URL already exist';
        }
    }else{
        echo 'Error-You have to enter short URL';
    }
}else{
        echo 'Invalid URL- you cant edit domain name';
    }
}else{
    echo 'Error- You have to enter short URL';
}




?>