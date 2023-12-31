<?php
//    https://www.youtube.com/watch?v=V8C4BIKCVUA&list=PLpwngcHZlPaf1aw42OGyitm4jh2Dlmi9c&index=7
include "php/config.php";

$new_url="";

if (isset($_GET)) {        //if there is set u value or u query string
 
    foreach($_GET as $key=>$val){
        $u = mysqli_real_escape_string($conn, $key);
        $new_url = str_replace('/', '', $u); //removing / sign from url
    }

    // //getting full url of that short url which we are getting from url  in db
    $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url ='{$new_url}'");
    //print_r($sql);
    if (mysqli_num_rows($sql) > 0) {
        $count_query = mysqli_query($conn, "UPDATE url SET clicks= clicks + 1 WHERE shorten_url ='{$new_url}'");
        if($count_query){
            //redirect
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:" . $full_url['full_url']);
        }
    } else {
        //
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorter Links</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <div class="wrapper">
        <form action="#">
            <i class="las la-link ul-icon"></i>
            <input type="text" name="full-url" placeholder="Enter or paste a long url" requrired>
            <button>Shorten</button>
        </form>
        <?php
        $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
        if (mysqli_num_rows($sql2) > 0) {
        ?>
            <div class="count">
                <?php
                $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
                $res = mysqli_fetch_assoc($sql3);


                $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
                $total = 0;
                while($c =mysqli_fetch_assoc($sql4)){
                    $total = $c['clicks'] + $total;
                }
                ?>
              <!-- end function will return the last key value of assocative array -->
                <span>Total Links: <span><?php echo end($res)?> </span>& total clicks: <span><?php echo $total?></span> </span>
                <a href="php/delete.php?delete=all">Clear All</a>
            </div>
            <div class="urls-area">
                <div class="title">
                    <li>Shorten URL</li>
                    <li>Original URL</li>
                    <li>Clicks URL</li>
                    <li>Action URL</li>
                </div>
            
            <?php
            while ($row = mysqli_fetch_assoc($sql2)) {
            ?>
                <div class="data">
                    <li>
                        <a href="http://url.localhost/?<?php echo $row['shorten_url'] ?>" target="_blank" >
                        <?php  if( 'url.localhost/?' .strlen($row['shorten_url']) > 50)  {
                         echo   'url.localhost/?'.substr($row['shorten_url'], 0,50);
                        }else{
                            echo   'url.localhost/?'.$row['shorten_url'];
                        }
                            ?>   
                        </a></li>
                    <li>
                         <?php  if(strlen($row['full_url']) > 65)  {
                         echo   substr($row['full_url'], 0,65).'...';
                        }else{
                            echo  $row['full_url'];
                        }
                            ?> 
                    </li>
                    <li><?php echo $row['clicks'] ?></li>
                    <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>"
                    >Delete</a></li>
                </div>
        <?php

            }
        }
        ?>
        </div>
    </div>

    <div class="blur-effects"></div>
    <div class="popup-box">
        <div class="info-box ">Your short link is ready. You can also edut your short link but can't educe once you save it.</div>
        <form action="#">
            <label>Edit your short url</label>
            <input type="text" spellcheck="false" value="">
            <i class="las la-copy uil-copy-alt"></i>
            <button>Save</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>