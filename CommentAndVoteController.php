<?php
include('bootstrap.php');

$action = $_REQUEST['action'];
$user_id = $_REQUEST['user_id'];
$show_id = $_REQUEST['show_id'];
header('Content-Type: application/json');
switch($action){
    case('get_comments'):
        $comments = $db->fetchResult('comments', array('show_id' => $show_id));
        echo json_encode($comments);
        break;
    case('add_comment'):
        $commment =  $_REQUEST['comment'];
        $db->runQuery('insert_comment', array('user_id' => $user_id, 'show_id' => $show_id, 'comment' => $commment));
        break;
    case('delete_comment'):
        $commment_id =  $_REQUEST['comment_id'];
        $db->runQuery('delete_comment', array('user_id' => $user_id, 'show_id' => $show_id, 'comment_id' => $commment_id));
        break;
    case('vote_count'):
        $count = $db->fetchResult('vote_count_per_show', array('show_id' => $show_id));
        echo json_encode($count);
        break;
    case('vote'):
        $vote_type =  $_REQUEST['vote_type'];
        $voted = $db->fetchResult('user_already_voted', array('show_id' => $show_id, 'user_id'=> $show_id));
        if($voted){
            $db->runQuery('update_vote', array('show_id' => $show_id, 'user_id' => $user_id, 'vote_type' => $vote_type));
        } else {
            $db->runQuery('create_vote', array('show_id' => $show_id, 'user_id' => $user_id, 'vote_type' => $vote_type));
        }
        break;
}
?>