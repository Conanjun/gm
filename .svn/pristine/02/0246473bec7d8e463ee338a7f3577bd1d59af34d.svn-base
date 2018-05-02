<?php
namespace Admin\Controller;
/* 多级选择：地区选择，分类选择 */
class MlselectionController
{
    public function index()
    {
        in_array($_GET['type'], array('region', 'gcategory','regionload')) or $this->json_error('invalid type');
        $pid = empty($_GET['pid']) ? 0 : $_GET['pid'];
	    $mod_region = D('region');
        switch ($_GET['type'])
        {
            case 'region':
                $regions = $mod_region->get_list('','',$pid);
                foreach ($regions as $key => $region)
                {
                    $regions[$key]['region_name'] = htmlspecialchars($region['region_name']);
                }
                echo json_encode(array('done' => true  , 'retval' => array_values($regions)));
                break;
            case 'regionload':
                $regions = $mod_region->get_parents($pid);
	            echo json_encode(array('done' => true  , 'retval' => array_values($regions)));
                break;
        }
    }
}

?>