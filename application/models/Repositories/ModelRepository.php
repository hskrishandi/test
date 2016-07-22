<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require 'BaseRepository.php';

/**
 * API Model Model.
 */
class ModelRepository extends BaseRepository
{
    /**
     * Get model from database. Return single model if $id not null,
     * if $id is null.
     *
     * @param $id
     *
     * @return model
     *
     * @author Leon
     */
    public function getById($id)
    {
        return $this->db->query("
            SELECT
                model.*,
                IFNULL(post.commentCount, 0) as commentCount,
                IFNULL(rating.score, 0) as rate
            FROM
                model_info AS model
                    LEFT JOIN
                (SELECT
                    postid, COUNT(DISTINCT commentid) AS commentCount
                FROM
                    post_comments
                GROUP BY postid) AS post ON post.postid = model.post_id
                    LEFT JOIN
                (SELECT
                    model_id, AVG(rate) AS score
                FROM
                    starrating
                GROUP BY model_id) AS rating ON rating.model_id = model.name
        " . ( $id === null ? "" : "WHERE model.id = $id" ) . "
            ORDER BY model.id
        ")->result();
    }
}
