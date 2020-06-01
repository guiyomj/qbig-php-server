<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
	
        $email=$_POST['email'];
	$b_name=$_POST['b_name'];

        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('SELECT q_name, pre_question_year, pre_question_year_no, wrong_count FROM qexam_history WHERE b_name=:b_name and email=:email ORDER BY date desc');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':b_name',$b_name);

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
		자격증명: <input type = "text" name = "b_name" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

