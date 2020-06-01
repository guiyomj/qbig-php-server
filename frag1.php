 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$email=isset($_POST['email']) ? $_POST['email'] : '';
$date=isset($_POST['date']) ? $_POST['date'] : '';
$q_name=isset($_POST['q_name']) ? $_POST['q_name'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="select ifnull(sum(question_count),0) as a1, ifnull(sum(wrong_count),0) as inc from qexam_history where email=:email and q_name=:q_name and date_format(date,'%Y-%m-%d')=:date";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':date',$date);
    $stmt->bindParam(':q_name',$q_name);

    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo "'";
        echo $email;
        echo "'은 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data,
               array('cor'=>$row["cor"], 'inc'=>$row["inc"]));
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
                id: <input type = "text" name = "email" />
                date: <input type = "text" name = "date" />
                q_name: <input type = "text" name = "q_name" />
                <input type = "submit" name = "submit" />
            </form>

   
   </body>
</html>
<?php
}

   
?>
