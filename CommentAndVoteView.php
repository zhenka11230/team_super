<!doctype html>
<html xmlns:ng="http://angularjs.org">
<script src="http://code.angularjs.org/0.9.19/angular-0.9.19.min.js" ng:autobind></script>
<body>
<div ng:controller="Controller">
    <div>Votes: {{votes}}</div>
    <input type="button" ng:click="downVote()" value="-">
    <input type="button" ng:click="unVote()" value="0">
    <input type="button" ng:click="upVote()" value="+">

    <ul>
        <li ng:repeat="comment in comments">
            <span>User: {{comment.first_name}}</span>
            <br/>
            <span>Comment: {{comment.comment}}</span>
            <br />
            <span>Date: {{comment.date}}</span>
            <br />
            <input style="display:{{canDelete(comment.user_id)}}" type="button" ng:click="deleteComment(comment.comment_id)" value='X'  size="35">
            <hr />
        </li>
    </ul>
    <form ng:submit="addComment()">
        <input type="text" name="comment" size="35"
               placeholder="enter your comment here">
        <input type="submit" value="add"><br>
    </form>
</div>

<script>
    Controller.$inject = ['$xhr'];
    function Controller($xhr) {
        var scope = this;

        scope.user_id = 1;

        scope.comments = null;
        scope.votes = null;
        scope.fetchComments = function() {
            $xhr('get', "CommentAndVoteController.php?action=get_comments&user_id=2&show_id=1", function(code, response) {
                scope.comments = response;
            });
        };
        scope.fetchVotes = function() {
            $xhr('get', "CommentAndVoteController.php?action=vote_count&user_id=2&show_id=1", function(code, response) {
                scope.votes = parseInt(eval(response));
            });
        };

        scope.fetchComments();
        scope.fetchVotes();

        scope.downVote = function(){
            $xhr('get', "CommentAndVoteController.php?action=vote&user_id=2&show_id=1&vote_type=-1", function(code, response) {
                scope.fetchVotes();
            });
        }

        scope.upVote = function(){
            $xhr('get', "CommentAndVoteController.php?action=vote&user_id=2&show_id=1&vote_type=1", function(code, response) {
                scope.fetchVotes();
            });
        }

        scope.unVote = function(){
            $xhr('get', "CommentAndVoteController.php?action=vote&user_id=2&show_id=1&vote_type=0", function(code, response) {
                scope.fetchVotes();
            });
        }

        scope.addComment = function(){
            $xhr('get', "CommentAndVoteController.php?action=add_comment&user_id=2&show_id=1&comment=" + scope.comment, function(code, response) {
                scope.fetchComments();
            });
        }

        scope.echo = function(id) {
            alert(id);
        }

        scope.canDelete = function(user_id){
            return user_id == scope.user_id ? "none" : "auto";
        }

        scope.deleteComment = function(comment_id){
            $xhr('get', "CommentAndVoteController.php?action=delete_comment&user_id=2&show_id=1&comment_id=" + comment_id, function(code, response) {
                scope.fetchComments();
            });
        }
    }

</script>