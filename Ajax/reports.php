<?php 

    try {
        $user = "ooprysmy_mtdbUser";
        $pass = "mtdbUser2020";
        $dbh = new PDO('mysql:host=localhost;dbname=ooprysmy_animehqLinks', $user, $pass);
        
    } catch (PDOException $e) {
        $dbh= null;
    }

    if($dbh){
        if(isset($_POST['action'])){

            
            switch($_POST['action']){

                case 'SET':
                    $gt = $dbh->prepare("INSERT INTO reports(userID , subj , cont ) VALUES( ? , ? , ? )");
                    $gt->execute(array($_POST['uid'] , $_POST['subject'] ,$_POST['cnt'] ));
                    echo json_encode(array("reponse" => true));
                    break;

            }
        }

    }