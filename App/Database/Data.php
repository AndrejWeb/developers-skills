<?php

namespace App\Database;
use App\Helpers\Functions;

defined('APP_NAME') || exit('No direct access allowed.');

class Data
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    //developers list
    public function getDevelopersList()
    {
        $select_developers = $this->db->runQuery("SELECT * FROM developers ORDER BY first_name ASC");
        $developers = $this->db->getQueryRows($select_developers);
        return $developers;
    }

    //skills list
    public function getSkillsList()
    {
        $select_skills = $this->db->runQuery("SELECT * FROM skills ORDER BY name ASC");
        $skills = $this->db->getQueryRows($select_skills);
        return $skills;
    }

    //data on initial page load
    public function pageInit()
    {
        $select_data = $this->db->runQuery("SELECT d.id AS DeveloperID, CONCAT(d.first_name, ' ', d.last_name) AS DeveloperName, 
GROUP_CONCAT(s.name SEPARATOR ', ') AS Skills, 
COUNT(s.id) AS SkillsCount,
GROUP_CONCAT(ds.proficiency) AS Proficiencies,
GROUP_CONCAT(ds.note SEPARATOR '---') AS Notes
FROM developers d
LEFT JOIN developers_skills ds ON d.id = ds.developer_id
LEFT JOIN skills s ON ds.skill_id = s.id
GROUP BY DeveloperID
ORDER BY DeveloperName ASC");

        $data = $this->db->getQueryRows($select_data);
        $data['group_by'] = 'developers';
        return $data;
    }

    //create and run SQL query based on provided criteria
    public function filterSQLQuery($params = null)
    {
        if(!is_array($params))
            return;

        $sql = [];
        $query_param_values = array();

        if(isset($params['group_by']) && $params['group_by'] == 'skills') {
            //group by skill
            $sql = [
                'query' => "SELECT s.id AS SkillID, s.name AS Skill,
GROUP_CONCAT(CONCAT(d.first_name, ' ', d.last_name)) AS Developers,
COUNT(d.id) AS DevelopersCount,
GROUP_CONCAT(ds.proficiency) AS Proficiencies,
GROUP_CONCAT(ds.note SEPARATOR '---') AS Notes
FROM developers d
LEFT JOIN developers_skills ds ON d.id = ds.developer_id
INNER JOIN skills s ON ds.skill_id = s.id 
WHERE 1 = 1",
                'group_by' => ' GROUP BY Skill',
                'order_by' => ' ORDER BY Skill ASC',
            ];
        }
        else if(isset($params['group_by']) && $params['group_by'] == 'proficiency') {
            //group by proficiency
            $sql = [
                'query' => "SELECT ds.proficiency AS Proficiency,
GROUP_CONCAT(DISTINCT CONCAT(d.first_name, ' ', d.last_name)) AS Developers,
COUNT(DISTINCT d.id) AS DevelopersCount,
GROUP_CONCAT(DISTINCT d.id) AS DevelopersID, 
GROUP_CONCAT(d.id) AS DevelopersIDs, 
GROUP_CONCAT(s.NAME) AS Skills
FROM developers d
LEFT JOIN developers_skills ds ON d.id = ds.developer_id
LEFT JOIN skills s ON ds.skill_id = s.id 
WHERE 1 = 1",
                'group_by' => ' GROUP BY Proficiency',
                'order_by' => ' ORDER BY Proficiency DESC',
            ];
        }
        else {
            //group by developer
            $params['group_by'] = 'developers';
            $sql = [
                'query' => "SELECT d.id AS DeveloperID, CONCAT(d.first_name, ' ', d.last_name) AS DeveloperName, 
GROUP_CONCAT(s.name SEPARATOR ', ') AS Skills, 
GROUP_CONCAT(s.id) AS SkillIDs,
COUNT(s.id) AS SkillsCount,
GROUP_CONCAT(ds.proficiency) AS Proficiencies,
GROUP_CONCAT(ds.note SEPARATOR '---') AS Notes
FROM developers d
LEFT JOIN developers_skills ds ON d.id = ds.developer_id
LEFT JOIN skills s ON ds.skill_id = s.id 
WHERE 1 = 1",
                'group_by' => ' GROUP BY DeveloperID',
                'order_by' => ' ORDER BY DeveloperName ASC',
            ];
        }

        if(isset($params['developer']) && $params['developer'] != 'all') {
            $sql['query'] .= " AND d.id = ?";
            $query_param_values[] = $params['developer'];
        }

        if(isset($params['skill']) && $params['skill'] != 'all') {
            $skills_array = explode(',', $params['skill']);
            $in_clause = implode(',', array_fill(0, count($skills_array), '?'));
            $sql['query'] .= " AND s.id IN ($in_clause)";
            $query_param_values[] = $skills_array;
        }

        if(isset($params['proficiency']) && $params['proficiency'] != 'all' && !isset($_POST['proficiency_greater'], $_POST['proficiency_less'], $_POST['proficiency_from'], $_POST['proficiency_to'])) {
            $sql['query'] .= " AND ds.proficiency = ?";
            $query_param_values[] = $params['proficiency'];
        }

        if(isset($params['proficiency_greater']) && $params['proficiency_greater'] > 0 && $params['proficiency_greater'] <= 10) {
            $sql['query'] .= " AND ds.proficiency > ?";
            $query_param_values[] = $params['proficiency_greater'];
        }

        if(isset($params['proficiency_less']) && $params['proficiency_less'] > 0 && $params['proficiency_less'] <= 10) {
            $sql['query'] .= " AND ds.proficiency < ?";
            $query_param_values[] = $params['proficiency_less'];
        }

        if(isset($params['proficiency_from']) || isset($params['proficiency_to'])) {
            $sql['query'] .= " AND ds.proficiency BETWEEN ";
            if(isset($params['proficiency_from']) && $params['proficiency_from'] > 0 && $params['proficiency_from'] <=10) {
                $sql['query'] .= "?";
                $query_param_values[] = $params['proficiency_from'];
            } else $sql['query'] .= "1";

            $sql['query'] .= " AND ";

            if(isset($params['proficiency_to']) && $params['proficiency_to'] > 0 && $params['proficiency_to'] <=10) {
                $sql['query'] .= "?";
                $query_param_values[] = $params['proficiency_to'];
            } else $sql['query'] .= "10";
        }

        if(isset($params['skills'])) {
            if($params['skills'] == 'inclusive' && $params['group_by'] == 'developers') {
                if(!isset($skills_array)) {
                    $skills_array = $this->getSkillsList();
                    $skills_array = array_column($skills_array, 'id');
                }
                sort($skills_array);
                $sql['having'] = ' HAVING SkillIDs = ?';
                $query_param_values[] = implode(",", $skills_array);
            }
        }

        $sql['query'] .= isset($sql['group_by']) ? $sql['group_by'] : '';
        $sql['query'] .= isset($sql['having']) ? $sql['having'] : '';
        $sql['query'] .= isset($sql['order_by']) ? $sql['order_by'] : '';

        if(isset($params['limit-s']) && $params['limit-s'] > 0) {
            $sql['query'] .= " LIMIT ". (int)htmlentities($params['limit-s']);
        }
        else if(isset($params['limit-c']) && $params['limit-c'] > 0) {
            $sql['query'] .= " LIMIT ". (int)htmlentities($params['limit-c']);
        }

        $query_param_values = Functions::arrayFlatten($query_param_values);

        $select = $this->db->getPreparedSQLStatement($sql['query']);
        $select_run = $this->db->runPreparedSQLStatement($select, $query_param_values);

        $data = $this->db->getQueryRows($select_run);
        $data['group_by'] = (isset($params['group_by'])) ? $params['group_by'] : 'developers';

        return $data;
    }
}
