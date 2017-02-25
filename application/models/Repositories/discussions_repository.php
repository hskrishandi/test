<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Discussions_repository extends Base_repository
{
    /**
     * Get by options
     *
     * @param count, pageOffset, showDeleted
     * @return discussions
     *
     * @author Leon
     */
    public function getByOptions($limit = 0, $offset = 0, $showDeleted = 0)
    {
        return $this->db->query("
            SELECT discussion.postid         AS id,
                   discussion.subject,
                   discussion.content,
                   discussion.datetime       AS created_at,
                   author.name               AS author,
                   author.photo              AS avatar,
                   Ifnull(comments.count, 0) AS count
            FROM   discussion
                   LEFT JOIN (SELECT id,
                                     displayname                   AS name,
                                     Concat(photo_path, photo_ext) AS photo
                              FROM   users) AS author
                          ON author.id = discussion.userid
                   LEFT JOIN (SELECT postid,
                                     Count(DISTINCT commentid) AS count
                              FROM   post_comments
                              GROUP  BY postid) AS comments
                          ON comments.postid = discussion.postid
            WHERE  discussion.del_status = $showDeleted
            ORDER  BY id  DESC
            LIMIT  $limit offset $offset;
        ")->result();
    }

    /**
     * Get by id
     *
     * @param id
     * @return discussion
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->db->query("
            SELECT discussion.postid         AS id,
                   discussion.subject,
                   discussion.content,
                   discussion.datetime       AS created_at,
                   author.name               AS author,
                   author.photo              AS avatar,
                   Ifnull(comments.count, 0) AS count
            FROM   discussion
                   LEFT JOIN (SELECT id,
                                     displayname                   AS name,
                                     Concat(photo_path, photo_ext) AS photo
                              FROM   users) AS author
                          ON author.id = discussion.userid
                   LEFT JOIN (SELECT postid,
                                     Count(DISTINCT commentid) AS count
                              FROM   post_comments
                              GROUP  BY postid) AS comments
                          ON comments.postid = discussion.postid
            WHERE  discussion.postid = $id;
        ")->result();
    }
}
