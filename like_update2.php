 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$no=isset($_POST['no']) ? $_POST['no'] : '';
//$email = isset($_POST['email']) ? $_POST['email'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="update board set likes=likes-1 where no=:no";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':no',$no);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo " 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 


        if (!$android) {
            echo "<pre>"; 
            print_r($data); 
            echo '</pre>';
        }else
        {
            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }
}
else {
    echo "검색하세요 ";
}

?>



<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if (!$android){
?>

<html>
   <body>
            <form action="<?php $_PHP_SELF ?>" method="POST">
                bno	: <input type = "text" name = "no" />
                <input type = "submit" name = "submit" />
            </form>

   
   </body>
</html>
<?php
}

   
?>
