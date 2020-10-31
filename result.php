<link rel="stylesheet" type="text/css" href="style.css">
<?php

session_start();
include('admin/config.php');
if (isset($_SESSION["userdata"]) && ($_SESSION["userdata"]["role"] == "Admin" || $_SESSION["userdata"]["role"] == "Student")) {

    $sql = "SELECT * FROM tests WHERE test_no=".$_SESSION["test"];
    $a = $_SESSION["ans"];
    $wrong_answers = 0;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $answers = json_decode($row["answers"], true);
            
            foreach ($answers as $key => $value) {
                
                foreach ($value as $k => $v) {
                    
                    if (count($a[$key]) == count($answers[$key])) {
                        if ($a[$key][$k] != $v) {
                            $wrong_answers+=1;
                            break;
                        }
                    } else {
                        $wrong_answers+=1;
                        break;    
                    }
                    
                }
            }
            echo "<br>Wrong Answers: ";
            echo $wrong_answers;
            echo "<br>Correct Answers: ";
            $ccc = 10-$wrong_answers;
            echo 10-$wrong_answers;
            $status = $ccc > $row["qualifying_marks"] ? "PASSED" : "FAILED";
            echo $status;

        }
    }
    unset($_SESSION["test"]);
    unset($_SESSION["ans"]);
    unset($_SESSION["userdata"]);
    print_r($_SESSION);

} else {
    echo "<h1>ACCESS DENIED!</h1>";

    print_r($_SESSION);
}

?>