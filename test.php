 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$q_name=isset($_POST['q_name']) ? $_POST['q_name'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$year_no = isset($_POST['year_no']) ? $_POST['year_no'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="select question_no, question1, solution_category_1, solution_category_2, solution_category_3, solution_category_4, solution, image_ox from qexam where q_name=:q_name and year=:year and year_no=:year_no";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':q_name', $q_name);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':year_no', $year_no);

    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo "'";
        echo $q_name;
        echo "'은 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data,
               array('qno'=>$row["question_no"], 'question'=>$row["question1"],'bogi1'=>$row["solution_category_1"],'bogi2'=>$row["solution_category_2"],'bogi3'=>$row["solution_category_3"],'bogi4'=>$row["solution_category_4"],'ans'=>$row["solution"],'img'=>$row["image_ox"]));
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
                자격증명: <input type = "text" name = "q_name" />
                년도: <input type = "text" name = "year" />
                회차: <input type = "text" name = "year_no" />
                <input type = "submit" name = "submit" />
            </form>

   
   </body>
</html>
<?php
}

   
?>
