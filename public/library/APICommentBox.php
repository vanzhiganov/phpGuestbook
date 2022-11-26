<?php
// OBJECTS:
//  member
//  site
//  page {"total": 0, "limit": 100, "from": 0, "items": []}
//  comment {"total": 0, "limit": 100, "from": 0, "items": []}

class APICommentBox  extends ClMysql {
    public function getComments($pageID, $parameters = array()) {
//      {"total": 0, "limit": 100, "from": 0, "items": []}
    }
    public function addComment($pageID, $parameters = array()) {
//      {"commentID": 111, "comment": "", "likes": 0, "dislikes": 0}
    }
    public function setCommentLike($pageID, $commentID, $parameters = array()) {
//      {"commentID": 111, "likes": 11, "dislikes": 111}
    }
    public function setCommentDislike($pageID, $commentID, $parameters = array()) {
//      {"commentID": 111, "likes": 11, "dislikes": 111}
    }
}
