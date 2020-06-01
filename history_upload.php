<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $email=$_POST['email'];
        $q_name=$_POST['q_name'];
        $question_count=$_POST['question_count'];
        $correct_count=$_POST['correct_count'];
        $wrong_count=$_POST['wrong_count'];
        $pre_question_year=$_POST['pre_question_year'];
        $pre_question_year_no=$_POST['pre_question_year_no'];
        $date=$_POST['date'];


        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('INSERT INTO qexam_history(email,q_name,pre_question_year,pre_question_year_no,question_count,correct_count,wrong_count) VALUES(:email,:q_name,:pre_question_year,:pre_question_year_no,:question_count,:correct_count,:wrong_count)');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':q_name',$q_name);
                $stmt->bindParam(':pre_question_year',$pre_question_year);
                $stmt->bindParam(':question_count',$question_count);
                $stmt->bindParam(':correct_count',$correct_count);
                $stmt->bindParam(':wrong_count',$wrong_count);
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
                q_count: <input type = "text" name = "question_count" />
                O_count: <input type = "text" name = "correct_count" />
                X_count: <input type = "text" name = "wrong_count" />
                year: <input type = "text" name = "pre_question_year" />
               	year_no: <input type = "text" name = "pre_question_year_no" />
                date: <input type = "text" name = "date" />

                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

