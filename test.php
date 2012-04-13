<?php
include "bootstrap.php";

//$voted = $db->fetchResult('user_already_voted', array('show_id' => 1, 'user_id'=> 2));
//if($voted){
//    $db->runQuery('update_vote', array('show_id' => 1, 'user_id' => 2, 'vote_type' => 1));
//} else {
//    $db->runQuery('create_vote', array('show_id' => 1, 'user_id' => 2, 'vote_type' => 1));
//}

$votes = $db->fetchResult('vote_count_per_show', array('show_id' => 1, 'user_id' => 2, 'vote_type' => 1));
print_r($votes);
//print_r($voted);