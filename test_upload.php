<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $email=$_POST['email'];
        $q_name=$_POST['q_name'];
        $question_no=$_POST['question_no'];
        $pre_question_year=$_POST['pre_question_year'];
        $pre_question_year_no=$_POST['pre_question_year_no'];
	$my_answer=$_POST['my_answer'];
        $date=$_POST['date'];


        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('INSERT INTO qexam_history_wrong_answer(email,q_name,pre_question_year,pre_question_year_no,question_no,my_answer) VALUES(:email,:q_name,:pre_question_year,:pre_question_year_no,:question_no,:my_answer)');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':q_name',$q_name);
                $stmt->bindParam(':pre_question_year',$pre_question_year);
                $stmt->bindParam(':question_no',$question_no);
		$stmt->bindParam(':my_answer',$my_answer);
                $stmt->bindParam(':pre_question_year_no',$pre_question_year_no);
               // $stmt->bindParam(':date',$date);



                if($stmt->execute())
                {
                    $successMSG = "추가 완료";
                }
                else
                {
                    $errMSG = "추가 에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                id: <input type = "text" name = "email" />
		exam: <input type = "text" name = "q_name" />
                qno: <input type = "text" name = "question_no" />
                year: <input type = "text" name = "pre_question_year" />
		my_answer: <input type="text" name="my_answer" />
               	year_no: <input type = "text" name = "pre_question_year_no" />
                date: <input type = "text" name = "date" />

                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

