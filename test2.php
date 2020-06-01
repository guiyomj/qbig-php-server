 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$email=isset($_POST['email']) ? $_POST['email'] : '';
$q_name=isset($_POST['q_name']) ? $_POST['q_name'] : '';
$pre_question_year = isset($_POST['pre_question_year']) ? $_POST['pre_question_year'] : '';
$pre_question_year_no = isset($_POST['pre_question_year_no']) ? $_POST['pre_question_year_no'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="select question_no, question1, solution_category_1, solution_category_2, solution_category_3, solution_category_4, solution, image_ox from qexam where question_no in (select question_no from qexam_history_wrong_answer where email=:email and q_name=:q_name and pre_question_year=:pre_question_year and pre_question_year_no=:pre_question_year_no)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':q_name', $q_name);
    $stmt->bindParam(':pre_question_year', $pre_question_year);
    $stmt->bindParam(':pre_question_year_no', $pre_question_year_no);
    //$stmt->bindParam(':date', $date);

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
                email: <input type = "text" name = "email" />
                자격증명: <input type = "text" name = "q_name" />
                년도: <input type = "text" name = "pre_question_year" />
                회차: <input type = "text" name = "pre_question_year_no" />
            
                <input type = "submit" name = "submit" />
            </form>

   
   </body>
</html>
<?php
}

   
?>
