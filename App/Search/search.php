<?php
session_start();

$unconditional_get = array('developer', 'proficiency', 'skills', 'group_by');
$conditional_get = array('skill', 'proficiency_greater', 'proficiency_less', 'proficiency_from', 'proficiency_to', 'limit_results', 'custom_limit');

if(!empty($_GET)) {
    if(isset($_SESSION['token']) && hash_equals($_SESSION['token']['value'], $_GET['token'])) {
        $q = '?q=';
        foreach($_GET as $key => $val) {

            if(in_array($key, $unconditional_get) && $val) {
                if(is_array($val)) {
                    $q .= $key . '/' . implode(',',$val) . '/';
                }
                else $q .= $key . '/' . $val . '/';
            }

            if(in_array($key, $conditional_get)) {
                switch($key) {
                    case 'skill':
                        if(isset($_GET['all-skills'])) {
                            $q .= $key . '/' . 'all/';
                        } else $q .= $key . '/' . implode(',', $val).'/';
                        break;

                    case 'proficiency_greater':
                        if(isset($_GET['proficiency_range']) && $_GET['proficiency_range'] == 'greater')
                            $q .= $key . '/' . (int)$val . '/';
                        break;

                    case 'proficiency_less':
                        if(isset($_GET['proficiency_range']) && $_GET['proficiency_range'] == 'less')
                            $q .= $key . '/' . (int)$val . '/';
                        break;

                    case 'proficiency_from':
                        if(isset($_GET['proficiency_range']) && $_GET['proficiency_range'] == 'between')
                            $q .= $key . '/' . (int)$val . '/';
                        break;

                    case 'proficiency_to':
                        if(isset($_GET['proficiency_range']) && $_GET['proficiency_range'] == 'between')
                            $q .= $key . '/' . (int)$val . '/';
                        break;

                    case 'limit_results':
                        if(isset($_GET['limit']) && $_GET['limit'] == 'select')
                            $q .= 'limit-s/' . (int)$val . '/';
                        break;

                    case 'custom_limit':
                        if(isset($_GET['limit']) && $_GET['limit'] == 'custom')
                            $q .= 'limit-c/' . (int)$val . '/';
                        break;

                    default:
                        break;
                }
            }
        }

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            echo $q;
            exit();
        }
        header('Location: ../../'.$q);
    } else {
        echo '<span style="color: red; font-size: 24px;">Token mismatch. Please try again or go to the homepage of the app and make the same request.</span>';
    }
}
