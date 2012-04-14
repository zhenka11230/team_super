<!doctype html>
<html xmlns:ng="http://angularjs.org">
<script src="http://code.angularjs.org/0.9.19/angular-0.9.19.min.js" ng:autobind></script>
<body>

<div id="menu-wrapper">
    <div id="menu">
        <ul>
            <li class="current_page_item"><a href="#">Homepage</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Photos</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Links</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>
    <!-- end #menu -->
</div>

<div id="wrapper" ng:controller="Controller">
    <div id="header-wrapper">
        <div id="header">
            <div id="logo">
                <h1><a href="#">Family Guy</a></h1>
                <p><input type="image" src="images/down.ico" ng:click="downVote()" value="-">&nbsp Votes: {{votes}} &nbsp<input type="image" src="images/up.ico" ng:click="upVote()" value="+"></p>
            </div>
        </div>
    </div>
    <!-- end #header -->
    <div id="page">
        <div id="page-bgtop">
            <div id="page-bgbtm">
                <div id="content">
                    <div class="post" ng:repeat="comment in comments">

                        <div class="entry">
                            <p><img src="images/person3.ico" class="alignleft border" /></p>
                            <p>{{comment.comment}}</p>
                        </div>

                        <p class="meta">Posted by <a href="#">{{comment.first_name}}</a> on {{comment.date}} <input style="display:{{canDelete(comment.user_id)}}" type="image" src="images/delete.ico" ng:click="deleteComment(comment.comment_id)" value='X'  size="35"></p>
                    </div>
                    <br/>
                    <form ng:submit="addComment()">
                        <textarea rows="10" cols="60" name="comment"
                               placeholder="enter your comment here">
                        </textarea>
                        <input type="image" src="images/add.ico" value="add"><br>
                    </form>

                    <div style="clear: both;">&nbsp;</div>
                </div>
                <!-- end #content -->
                <div id="sidebar">
                    <ul>
                        <li>
                            <h2>Aliquam tempus</h2>
                            <p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
                        </li>
                        <li>
                            <h2>Categories</h2>
                            <ul>
                                <li><a href="#">Aliquam libero</a></li>
                                <li><a href="#">Consectetuer adipiscing elit</a></li>
                                <li><a href="#">Metus aliquam pellentesque</a></li>
                                <li><a href="#">Suspendisse iaculis mauris</a></li>
                                <li><a href="#">Urnanet non molestie semper</a></li>
                                <li><a href="#">Proin gravida orci porttitor</a></li>
                            </ul>
                        </li>
                        <li>
                            <h2>Blogroll</h2>
                            <ul>
                                <li><a href="#">Aliquam libero</a></li>
                                <li><a href="#">Consectetuer adipiscing elit</a></li>
                                <li><a href="#">Metus aliquam pellentesque</a></li>
                                <li><a href="#">Suspendisse iaculis mauris</a></li>
                                <li><a href="#">Urnanet non molestie semper</a></li>
                                <li><a href="#">Proin gravida orci porttitor</a></li>
                            </ul>
                        </li>
                        <li>
                            <h2>Archives</h2>
                            <ul>
                                <li><a href="#">Aliquam libero</a></li>
                                <li><a href="#">Consectetuer adipiscing elit</a></li>
                                <li><a href="#">Metus aliquam pellentesque</a></li>
                                <li><a href="#">Suspendisse iaculis mauris</a></li>
                                <li><a href="#">Urnanet non molestie semper</a></li>
                                <li><a href="#">Proin gravida orci porttitor</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- end #sidebar -->
                <div style="clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
    <!-- end #page -->
</div>
<div id="footer">
    <p>Copyright (c) 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org/"> CSS Templates</a>.</p>
</div>
<!-- end #footer -->




</body>
</html>

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
                scope.comment = null;
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

<style>
/*
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
*/

body {
margin: 0;
padding: 0;
background: #000;
font-family: Arial, Helvetica, sans-serif;
font-size: 14px;
color: #181B20;
}

h1, h2, h3 {
margin: 0;
padding: 0;
font-family: 'Arvo', serif;
font-weight: normal;
color: #FFA800;
}

h1 {
font-size: 2em;
}

h2 {
font-size: 2.4em;
}

h3 {
font-size: 1.6em;
}

p, ul, ol {
margin-top: 0;
line-height: 180%;
}

ul, ol {
}

a {
text-decoration: none;
color: #6E7A8A;
}

a:hover {
text-decoration: underline;
}

img.border {
border: none;
}

img.alignleft {
float: left;
margin-right: 25px;
}

img.alignright {
float: right;
}

img.aligncenter {
margin: 0px auto;
}

#wrapper {
margin: 0 auto;
padding: 0;
}

/* Header */

#header-wrapper {
height: 240px;
background: url(images/img01.jpg) no-repeat center top;
}

#header {
width: 960px;
height: 240px;
margin: 0 auto;
}

/* Logo */

#logo {
width: 980px;
height: 100px;
margin: 0px auto;
padding: 80px 0px 0px 0px;
color: #FFFFFF;
}

#logo h1, #logo p {
display: block;
margin: 0;
padding: 0;
}

#logo h1 {
margin: 0px;
letter-spacing: -1px;
text-align: center;
text-transform: uppercase;
font-size: 54px;
font-weight: bold;
color: #FFFFFF;
}

#logo h1 a {
color: #FFFFFF;
}

#logo p {
text-align: center;
text-transform: uppercase;
font-family: 'Arvo', serif;
font-size: 20px;
}

#logo a {
border: none;
background: none;
text-decoration: none;
color: #FFFFFF;
}

/* Search */

#search {
float: right;
width: 280px;
height: 100px;
padding: 0;
}

#search form {
height: 41px;
margin: 0;
padding: 60px 0 0 30px;
}

#search fieldset {
margin: 0;
padding: 0;
border: none;
}

#search-text {
width: 195px;
padding: 6px 10px;
border: none;
background: #FFFFFF;
text-transform: lowercase;
font: normal 11px Arial, Helvetica, sans-serif;
color: #7F7F81;
}

#search-submit {
display: none;
}

/* Menu */

#menu-wrapper {
overflow: hidden;
height: 60px;
background: #212121;
}

#menu {
width: 940px;
margin: 0px auto;
}

#menu ul {
margin: 0;
padding: 0px 0px 0px 0px;
list-style: none;
line-height: normal;
}

#menu li {
float: left;
margin-right: 1px;
}

#menu a {
display: block;
float: left;
height: 60px;
margin: 0px;
padding: 0px 30px 0px 30px;
line-height: 60px;
letter-spacing: -1px;
text-decoration: none;
text-transform: uppercase;
font-family: 'Arvo', serif;
font-size: 14px;
font-weight: normal;
color: #B5B5B5;
border: none;
}

#menu .current_page_item a {
background: #FFA800;
color: #FFFFFF;
}

#menu a:hover {
background: #FFA800;
text-decoration: none;
color: #FFFFFF;
}

/* Page */

#page {
width: 980px;
margin: 0 auto;
padding: 0;
background-color: #FFFFFF;
}

#page-bgtop {
}

#page-bgbtm {
margin: 0px;
padding: 40px 30px 0px 30px;
}

/* Content */

#content {
float: right;
width: 600px;
padding: 0px 0px 0px 0px;
}

.post {
clear: both;
border-bottom: 1px solid #B6BFD0;
}

.post .title {
padding-top: 10px;
letter-spacing: -2px;

}

.post .title a {
color: #FFA800;
border: none;
}

.post .meta {
padding-bottom: 10px;
text-align: left;
font-family: Arial, Helvetica, sans-serif;
font-size: 11px;
font-style: italic;
}

.post .meta a {
}

.post .entry {
text-align: justify;
margin-bottom: 25px;
padding: 10px 0px 0px 0px;
}

.links {
display: block;
width: 96px;
padding: 2px 0px 2px 0px;
background: #A53602;
text-align: center;
text-transform: uppercase;
font-size: 10px;
color: #FFFFFF;
}

/* Sidebar */

#sidebar {
float: left;
width: 240px;
padding: 0px 0px 0px 0px;
}

#sidebar ul {
margin: 0;
padding: 0;
list-style: none;
}

#sidebar li {
margin: 0;
padding: 0;
}

#sidebar li ul {
margin: 0px 15px;
padding-bottom: 30px;
}

#sidebar li li {
padding-left: 20px;
line-height: 35px;
background: url(images/img07.jpg) no-repeat left 14px;
}

#sidebar li li span {
display: block;
margin-top: -20px;
padding: 0;
font-size: 11px;
font-style: italic;
}

#sidebar h2 {
height: 38px;
margin-bottom: 20px;
padding: 12px 0 0 15px;
border-bottom: 1px solid #B6BFD0;
letter-spacing: -1px;
font-size: 24px;
color: #FFA800;
}

#sidebar p {
margin: 0 0px;
padding: 0px 20px 20px 20px;
text-align: justify;
}

#sidebar a {
border: none;
}

#sidebar a:hover {
text-decoration: underline;
}

/* Calendar */

#calendar {
}

#calendar_wrap {
padding: 20px;
}

#calendar table {
width: 100%;
}

#calendar tbody td {
text-align: center;
}

#calendar #next {
text-align: right;
}

/* Footer */

#footer {
width: 960px;
height: 55px;
margin: 0px auto 40px auto;
border-top: 1px solid #B6BFD0;
font-family: Arial, Helvetica, sans-serif;
}

#footer p {
margin: 0;
padding-top: 18px;
line-height: normal;
text-align: center;
color: #576475;
}

#footer a {
color: #576475;
}
</style>