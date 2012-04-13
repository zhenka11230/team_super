<?php
class DB{
private $mysql_host = 'localhost';
private $mysql_user = 'root';
private $mysql_password = '';
private $use_db = 'team_super_db';

private $connection;
private $db_selected;

public function __construct(){
    $this->connection = mysql_connect(
    $this->mysql_host,
    $this->mysql_user,
    $this->mysql_password);
    if (!$this->connection) {
        die('Not connected : ' . mysql_error());
    }
//    echo "DB: Connected <br />";

    $this->db_selected = mysql_select_db($this->use_db, $this->connection);
    if (!$this->db_selected) {
        die ("Can't use $this->use_db : " . mysql_error());
    }
//    echo "DB: Selected $this->use_db  <br />";
}

public function fetchResult($query_name, $args){
    $possible_args = array('id', 'user_id', 'show_id', 'comment');

    foreach($possible_args as $arg){
        if(!isset($args[$arg])){
            $args[$arg] = 'not set';
        }
    }

    $queries = array(
        'tvshow_name_by_show_id' => "Select show_name From tvshow Where show_id = {$args['id']}",
        'category_name_by_show_id' => "Select category From category Inner Join tvshow On tvshow.show_id = category.category_id Where show_id = {$args['id']}",
        'user_already_voted' => "Select count(*) From tvshowvote Where user_id = {$args['user_id']} And show_id = {$args['show_id']}",
        'vote_count_per_show' => "SELECT Sum(vote_type) FROM tvshowvote Where show_id = {$args['show_id']}",
        'comments' => "Select comment_id, tvshowcomment.user_id, comment, first_name, date From tvshowcomment Inner Join user On user.user_id = tvshowcomment.user_id  Where show_id = {$args['show_id']} ORDER BY date Asc"
    );

    $only_this_field = array(
        'tvshow_name_by_show_id' => 'show_name',
        'category_name_by_show_id' => 'category',
        'user_already_voted' => 'count(*)',
        'vote_count_per_show' => 'Sum(vote_type)',
    );

    $only_first_row = array(
        'tvshow_name_by_show_id',
        'category_name_by_show_id',
        'user_already_voted',
        'vote_count_per_show');

    $query = $queries[$query_name];
    $result = mysql_query($query, $this->connection);
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "<br />";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    $rows = array();
    while($row = mysql_fetch_assoc($result)) {
        array_push($rows, $row);
    }

    if(isset($only_this_field[$query_name])){
        $field_of_interest = $only_this_field[$query_name];
        $filtered_rows = array();
        foreach($rows as $row){
            array_push($filtered_rows, $row[$field_of_interest]);
        }

        $rows = $filtered_rows;
    }

    return in_array($query_name, $only_first_row) ? $rows[0] : $rows;

}

public function runQuery($query_name, $args){
    $possible_args = array('id', 'user_id', 'show_id', 'comment', 'vote_type', 'comment_id');

    foreach($possible_args as $arg){
        if(!isset($args[$arg])){
            $args[$arg] = 'not set';
        }
    }

    $queries = array(
        'insert_comment' => "INSERT INTO tvshowcomment (show_id, user_id, comment) VALUES ({$args['show_id']}, {$args['user_id']}, \"{$args['comment']}\")",
        'create_vote' => "Insert into tvshowvote (user_id, show_id, vote_type) values({$args['user_id']}, {$args['show_id']}, {$args['vote_type']})",
        'update_vote' =>  "Update tvshowvote Set vote_type = {$args['vote_type']} Where user_id = {$args['user_id']} And show_id = {$args['show_id']}",
        'delete_comment' => "DELETE FROM tvshowcomment WHERE comment_id = {$args['comment_id']}"
    );

    $query = $queries[$query_name];
    $result = mysql_query($query, $this->connection);
    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "<br />";
        $message .= 'Whole query: ' . $query;
        die($message);
    }

    return true;
}






}