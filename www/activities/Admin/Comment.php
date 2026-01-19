<?php

namespace Admin;

use database\DataBase;

class Comment extends Admin{ 
        
        public function index()
        {
                $db = new DataBase();
                // allow optional filtering by post id via GET: admin/comment?post_id=123
                $postTitle = null;
                if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
                        $postId = (int) $_GET['post_id'];
                        $comments = $db->select('SELECT comments.*, posts.title AS post_title, users.email AS email FROM comments LEFT JOIN posts ON comments.post_id = posts.id LEFT JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY `id` DESC', [$postId]);
                        // try to fetch post title for UI
                        $postRow = $db->select('SELECT title FROM posts WHERE id = ?;', [$postId])->fetch();
                        if (!empty($postRow)) {
                                $postTitle = $postRow['title'];
                        }
                } else {
                        $comments = $db->select('SELECT comments.*, posts.title AS post_title, users.email AS email FROM comments LEFT JOIN posts ON comments.post_id = posts.id LEFT JOIN users ON comments.user_id = users.id ORDER BY `id` DESC');
                }

                // mark unseen comments as seen (existing behaviour)
                $unseenComments = $db->select('SELECT * FROM comments WHERE status = ?', ['unseen']);
                foreach($unseenComments as $comment){
                        $db->update('comments', $comment['id'], ['status'], ['seen']);
                }

                // if requested via ajax, return only the comments table partial
                if (isset($_GET['ajax'])) {
                        require_once(BASE_PATH . '/template/admin/comments/partial.php');
                        exit;
                }

                require_once(BASE_PATH . '/template/admin/comments/index.php');
        }

        public function changeStatus($id)
        {
                $db = new DataBase();
                $comment = $db->select('SELECT * FROM comments WHERE id = ?;', [$id])->fetch();
                if(empty($comment)){
                        $this->redirectBack();  
                }
                if($comment['status'] == 'seen'){
                        $db->update('comments', $id, ['status'], ['approved']);
                }
                else{
                        $db->update('comments', $id, ['status'], ['seen']);
                }
                $this->redirectBack();
        }

     
     

}