 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$bno=isset($_POST['bno']) ? $_POST['bno'] : '';
//$category = isset($_POST['e_class']) ? $_POST['e_class'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="select cno, email, user_name, content, qdate from comment where bno=:bno order by cno desc";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':bno',$bno);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo " 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data,
               array( 'cno'=>$row["cno"],'email'=>$row["email"],'user_name'=>$row["user_name"],'content'=>$row["content"],'date'=>$row["qdate"]));
        }


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
                bno: <input type = "text" name = "bno" />
                <input type = "submit" name = "submit" />
            </form>

   
   </body>
</html>
<?php
}

   
?>
