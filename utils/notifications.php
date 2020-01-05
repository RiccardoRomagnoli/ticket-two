<?php
    require_once '../initializer.php';
    if($_POST['idNotification'] != ''){
        if($_POST['action'] == 'read'){
            $dbh->changeNotificationToReaded($_POST['idNotification']);
        } else if($_POST['action'] == 'delete'){
            $dbh->deleteNotification($_POST['idNotification']);
        }
    }
?>