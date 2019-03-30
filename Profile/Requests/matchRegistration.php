<?php

if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}
session_start();
require_once '../../includes/Connection.php';
$senderID = $_POST["senderID"];
$commonInterests = $_POST["commonInterests"];
$individualCommonInterests = explode(", ",$commonInterests);// split interests
$individualCommonInterests =array_map('trim',$individualCommonInterests);// trim any whitespaces on both sides

try {
    //Begin sql transaction
    $conn -> begin_transaction();
    // register matching for each interest
    foreach ($individualCommonInterests as $commonInterest)
    {
        trim($commonInterest);//strip these characters: " \t\n\r\0\x0B"
        $sql1 = $conn -> query("INSERT INTO matches (User1, User2, MatchInterest) VALUES 
                                      ($senderID, $_SESSION[user_id], '".$commonInterest."')");
        //increase interest's number of matches
        $sql2 = $conn ->query("UPDATE interests SET NumOfMatches = NumOfMatches + 1 WHERE InterestName ='".$commonInterest."';");
    }
    // delete any matching requests between two users
    $sql3 = $conn -> query("DELETE FROM matching_requests WHERE (SenderID = $senderID OR SenderID = $_SESSION[user_id])
                                                                        AND (ReceiverID = $senderID OR ReceiverID = $_SESSION[user_id])");
    // register notification to be notify user that its request is being accepted
    $sql4 = $conn -> query("INSERT INTO notifications (toUserID, fromUserID, CommonInterests) VALUES ($senderID, $_SESSION[user_id],'".$commonInterests."' )");

    $conn->commit();
    echo "success";
} catch (Exception $e) { // An exception has been thrown
    $conn->rollback();
    echo "fail";
}

$conn -> close();
exit();