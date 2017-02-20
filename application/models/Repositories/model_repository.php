<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model Repositories.
 */
class Model_repository extends Base_repository
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

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
        return $this->db->query('
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
        '.($id === null ? '' : "WHERE model.id = $id").'
            ORDER BY model.id
        ')->result();
    }

    /**
     * Get model Parameters.
     *
     * @param  $id
     *
     * @return model parameters
     *
     * @author Leon
     */
    public function getParametersById($id)
    {
        return $this->db->query("
            SELECT
                tab.title,
                param.name,
                param.description,
                param.unit,
                param.default,
                param.editable
            FROM
                model_params_tab_title AS tab
                    RIGHT JOIN
                (SELECT
                    *
                FROM
                    model_params
                WHERE
                    model_params.model_id = $id) AS param ON tab.model_id = $id
                    AND param.instance = tab.instance
            ORDER BY tab.instance;
        ")->result();
    }

    /**
     * Get model bias.
     *
     * @param  $id
     *
     * @return model bias
     *
     * @author Leon
     */
    public function getBiasById($id)
    {
        return $this->db->query("
            SELECT
                *
            FROM
                model_bias
            WHERE
                model_id = $id;
        ")->result();
    }

    /**
     * Get model output.
     *
     * @param $id
     *
     * @return model output
     *
     * @author Leon
     */
    public function getOutputById($id)
    {
        return $this->db->query("
            SELECT
                *
            FROM
                model_outputs
            WHERE
                model_id = $id;
        ")->result();
    }

    /**
     * Get comment by id
     *
     * @param $id
     * @return comments
     *
     * @author Leon
     */
    public function getCommentsById($id)
    {
        return $this->db->query("
            SELECT
                comments.comment,
                comments.datetime as time,
                users.displayname as username
            FROM
                post_comments AS comments
                    LEFT JOIN
                (SELECT
                    *
                FROM
                    users) AS users ON users.id = comments.userid
            WHERE
                postid IN (SELECT
                        post_id
                    FROM
                        model_info
                    WHERE
                        id = $id)
                    AND comments.type = 'model'
            ORDER BY comments.commentid DESC;
        ")->result();
    }

    /**
     * Get Model Description
     *
     * @param $name
     * @return description
     *
     * @NOTE This is not a good approach to do so, please improve this
     * description feature if possible (e.g. use Markdown instead
     * of html code, maybe save them in database)
     *
     * @author Leon
     */
    public function getDescriptionByName($name)
    {
        $name = $this->db->escape_str($name);
        $description = new stdClass(); // Create new class
        // Read model descriptions
        $description->description = read_file('application/views/models/descriptions/' . $name . '/description.php');
        $description->information = read_file('application/views/models/descriptions/' . $name . '/information.php');
        $description->reference = read_file('application/views/models/descriptions/' . $name . '/reference.php');
        return $description;
    }

    /**
     * Get user experience.
     *
     * @param $limit = 2, $offset = 0
     *
     * @return user experience
     *
     * @author Leon
     */
    public function getUserExperience($limit = 2, $offset = 0)
    {
        $this->db->select('ue.id, ue.comment, ue.date, u.first_name, u.last_name, u.organization')
        ->from('user_experience ue')
        ->join('users u', 'u.id = ue.user_id', 'inner')
        ->where('ue.approval_status', 1)
        ->order_by('ue.date desc')
        ->limit($limit, $offset);
        return $this->db->get()->result();
    }
}
