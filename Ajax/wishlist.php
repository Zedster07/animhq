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

                case 'GET':
                    $gt = $dbh->prepare("SELECT * FROM animehq_wishlist WHERE userID = ? and contentID = ?");
                    $gt->execute(array($_POST['uid'] , $_POST['pid']));
                    if ($gt->rowCount() != 0){
                        echo json_encode(array("reponse" => true));
                    } else {
                        echo json_encode(array("reponse" => false , "pid" => $_POST['pid'] , "uid" => $_POST['uid'] ));
                    }
                    break;
                case 'SET':
                    $gt = $dbh->prepare("INSERT INTO animehq_wishlist (userID , contentID) VALUES( ? , ? )");
                    $gt->execute(array($_POST['uid'] , $_POST['pid']));
                    echo json_encode(array("reponse" => true));
                    break;
                case 'DEL':
                    $gt = $dbh->prepare("DELETE FROM animehq_wishlist WHERE userID = ? and contentID = ? ");
                    $gt->execute(array($_POST['uid'] , $_POST['pid']));
                    echo json_encode(array("reponse" => true));
                    break;    
            }



        }
    } else {
        echo json_encode(array("reponse" => false));
    }