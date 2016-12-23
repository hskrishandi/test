<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Model Repositories.
 */
class Model_repository extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
     * Get user library.
     *
     * @param $id
     *
     * @return $value
     *
     * @author Leon
     */
    public function getUserLibraryByUserId($id)
    {
        return $this->db->query("
            SELECT
                model.short_name AS model_name,
                param.name AS nick_name,
                param.data
            FROM
                model_info AS model
                    LEFT JOIN
                (SELECT
                    *
                FROM
                    user_param_sets) AS param ON param.model_id = model.id
            WHERE
                param.user_id = $id
            ORDER BY model_id;
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
        $description = new stdClass(); // Create new class
        // Read model descriptions
        $description->introduction = read_file('application/views/models/descriptions/' . $name . '/introduction.php');
        $description->information = read_file('application/views/models/descriptions/' . $name . '/information.php');
        $description->reference = read_file('application/views/models/descriptions/' . $name . '/reference.php');
        return $description;
    }
}
