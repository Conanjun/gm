<?php

function word2pdf($wordpath, $outPdfPath, $ext)
{
	if (empty($wordpath)) return false;
	$extlist = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx');
	if (!in_array($ext, $extlist)) {
		return false;
	}
	try {
		$p = "java -jar " . C('JOBPATH') . ' ' . $wordpath . ' ' . $outPdfPath;
		exec($p);
		return true;
	} catch (Exception $e) {
		return false;
	}
}

function topdf($url, $out = null, $o = 'L')
{
	$path = getpathpdf();
	if ($o == 'L') {
		if (PHP_OS == 'Linux' || PHP_OS == 'Unix') {
			exec("xvfb-run wkhtmltopdf --orientation Landscape $url " . $path, $output, $status);
		} else {
			exec("wkhtmltopdf.exe --orientation Landscape $url " . $path, $output, $status);
		}
	} else {
		if (PHP_OS == 'Linux' || PHP_OS == 'Unix') {
			exec("wkhtmltopdf $url " . $path);
		} else {
			exec("wkhtmltopdf.exe $url " . $path);
		}
	}
	if ($out) {
		ob_get_contents();
		ob_flush();
		ob_clean();
		ob_end_flush();
		ob_end_clean();
		header("Content-type:application/pdf");
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($path));
		header('Content-Disposition: inline; filename="' . $path . '";');
		echo file_get_contents($path);
	} else {
		return $path;
	}
}


function topdf1($url, $out = null, $o = 'L')
{
	$uid = UID;
	$c = C('DOWNLOAD_UPLOAD');
	$path = $c['rootPath'] . "/Pdf/" . $uid;
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	$dh = opendir($path);

	while ($file = readdir($dh)) {
		if ($file != "." && $file != "..") {
			$fullpath = $path . "/" . $file;
			if (!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
	$path = $path . '/';
	$prefix = 'pdf_';
	$output_file = $prefix . time() . rand(10000, 99999) . '.pdf';
	$path = $path . $output_file;
	if ($o == 'L') {
		if (PHP_OS == 'Linux' || PHP_OS == 'Unix') {
			exec("wkhtmltopdf --orientation Landscape $url " . $path);
		} else {
			exec("wkhtmltopdf.exe --orientation Landscape $url " . $path);
		}
	} else {
		if (PHP_OS == 'Linux' || PHP_OS == 'Unix') {
			exec("wkhtmltopdf $url " . $path);
		} else {
			exec("wkhtmltopdf.exe $url " . $path);
		}
	}
	if ($out) {
		ob_get_contents();
		ob_flush();
		ob_clean();
		ob_end_flush();
		ob_end_clean();
		header("Content-type:application/pdf");
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($path));
		header('Content-Disposition: inline; filename="' . $path . '";');
		echo file_get_contents($path);
	} else {
		return $path;
	}
}

/**
 * 生成pdf
 *
 * @param string $html
 *
 * @return string
 */
function pdf($html = '<h1 style="color:red">hello word</h1>')
{
	vendor('Tcpdf.tcpdf');
	$pdf = new \Tcpdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Nicola Asuni');
	$pdf->SetTitle('TCPDF Example 006');
	$pdf->SetSubject('TCPDF Tutorial');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
		require_once(dirname(__FILE__) . '/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('stsongstdlight', '', 14, '', true);

	// add a page
	$pdf->AddPage();
	$pdf->writeHTML($html, true, false, true, false, '');
	$contract_data = $pdf->Output('example_001.pdf', 'S');
	$path = getpathpdf();
	file_put_contents($path, $contract_data);
	return $path;
}

function getpathpdf()
{
	$c = C('DOWNLOAD_UPLOAD');
	$path = $c['rootPath'] . "Pdf/offer/";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	$prefix = 'offer_';
	$output_file = $prefix . time() . rand(10000, 99999) . '.pdf';
	$path = $path . $output_file;
	return $path;
}

/* 解析列表定义规则*/

function get_list_field($data, $grid, $model)
{
	// 获取当前字段数据
	foreach ($grid['field'] as $field) {
		$array = explode('|', $field);
		$temp = $data[$array[0]];
		// 函数支持
		if (isset($array[1])) {
			$temp = call_user_func($array[1], $temp);
		}
		$data2[$array[0]] = $temp;
	}
	if (!empty($grid['format'])) {
		$value = preg_replace_callback('/\[([a-z_]+)\]/', function ($match) use ($data2) {
			return $data2[$match[1]];
		}, $grid['format']);
	} else {
		$value = implode(' ', $data2);
	}

	// 链接支持
	if (!empty($grid['href'])) {
		$links = explode(',', $grid['href']);
		foreach ($links as $link) {
			$array = explode('|', $link);
			$href = $array[0];
			if (preg_match('/^\[([a-z_]+)\]$/', $href, $matches)) {
				$val[] = $data2[$matches[1]];
			} else {
				$show = isset($array[1]) ? $array[1] : $value;
				// 替换系统特殊字符串
				$href = str_replace(
				array('[DELETE]', '[EDIT]', '[MODEL]'),
				array('del?ids=[id]&model=[MODEL]', 'edit?id=[id]&model=[MODEL]', $model['id']),
				$href);

				// 替换数据变量
				$href = preg_replace_callback('/\[([a-z_]+)\]/', function ($match) use ($data) {
					return $data[$match[1]];
				}, $href);

				$val[] = '<a href="' . U($href) . '">' . $show . '</a>';
			}
		}
		$value = implode(' ', $val);
	}
	return $value;
}

function get_model_by_id($id)
{
	return $model = M('Model')->getFieldById($id, 'title');
}


/**
 *
 * @param $ac
 *
 * @return mixed
 */
function ac_name($ac)
{
	$a = M('action_name')->field('name')->where("code = '" . $ac . "'")->find();
	if ($a && $a['name']) {
		return $a['name'];
	} else {
		return $ac;
	}
}

function tf_name($t, $f)
{
	$a = M('table_field')->field('name')->where("code = '" . $f . "' and tname='" . $t . "'")->find();
	if ($a && $a['name']) {
		return $a['name'];
	} else {
		return $f;
	}
}

// 获取属性类型信息
function get_attribute_type($type = '')
{
	// TODO 可以加入系统配置
	static $_type = array(
        'num' => array('数字', 'int(10) UNSIGNED NOT NULL'),
        'string' => array('字符串', 'varchar(255) NOT NULL'),
        'textarea' => array('文本框', 'text NOT NULL'),
        'datetime' => array('时间', 'int(10) NOT NULL'),
        'bool' => array('布尔', 'tinyint(2) NOT NULL'),
        'select' => array('枚举', 'char(50) NOT NULL'),
        'radio' => array('单选', 'char(10) NOT NULL'),
        'checkbox' => array('多选', 'varchar(100) NOT NULL'),
        'editor' => array('编辑器', 'text NOT NULL'),
        'picture' => array('上传图片', 'int(10) UNSIGNED NOT NULL'),
        'file' => array('上传附件', 'int(10) UNSIGNED NOT NULL'),
	);
	return $type ? $_type[$type][0] : $_type;
}

/**
 * 获取对应状态的文字信息
 *
 * @param int $status
 *
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_status_title($status = null)
{
	if (!isset($status)) {
		return false;
	}
	switch ($status) {
		case -1 :
			return '已删除';
			break;
		case 0  :
			return '禁用';
			break;
		case 1  :
			return '正常';
			break;
		case 2  :
			return '待审核';
			break;
		default :
			return false;
			break;
	}
}

// 获取数据的状态操作
function show_status_op($status)
{
	switch ($status) {
		case 0  :
			return '启用';
			break;
		case 1  :
			return '禁用';
			break;
		case 2  :
			return '审核';
			break;
		default :
			return false;
			break;
	}
}

/**
 * 获取文档的类型文字
 *
 * @param string $type
 *
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_document_type($type = null)
{
	if (!isset($type)) {
		return false;
	}
	switch ($type) {
		case 1  :
			return '目录';
			break;
		case 2  :
			return '主题';
			break;
		case 3  :
			return '段落';
			break;
		default :
			return false;
			break;
	}
}

/**
 * 获取配置的类型
 *
 * @param int $type 配置类型
 *
 * @return mixed
 */
function get_config_type($type = 0)
{
	$list = C('CONFIG_TYPE_LIST');
	return $list[$type];
}

/**
 * 获取配置的分组
 *
 * @param int $group 配置分组
 *
 * @return string
 */
function get_config_group($group = 0)
{
	$list = C('CONFIG_GROUP_LIST');
	return $group ? $list[$group] : '';
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map                         映射关系二维数组  array(
 *                                           '字段名1'=>array(映射关系数组),
 *                                           '字段名2'=>array(映射关系数组),
 *                                           ......
 * @param       $data                        )
 *
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data, $map = array('status' => array(1 => '正常', -1 => '删除', 0 => '禁用', 2 => '未审核', 3 => '草稿')))
{
	if ($data === false || $data === null) {
		return $data;
	}
	$data = (array)$data;
	foreach ($data as $key => $row) {
		foreach ($map as $col => $pair) {
			if (isset($row[$col]) && isset($pair[$row[$col]])) {
				$data[$key][$col . '_text'] = $pair[$row[$col]];
			}
		}
	}
	return $data;
}

/**
 * 动态扩展左侧菜单,base.html里用到
 *
 * @param $extra_menu
 * @param $base_menu
 */
function extra_menu($extra_menu, &$base_menu)
{
	foreach ($extra_menu as $key => $group) {
		if (isset($base_menu['child'][$key])) {
			$base_menu['child'][$key] = array_merge($base_menu['child'][$key], $group);
		} else {
			$base_menu['child'][$key] = $group;
		}
	}
}

/**
 * 获取参数的所有父级分类
 *
 * @param int $cid 分类id
 *
 * @return array 参数分类和父类的信息集合
 * @author huajie <banhuajie@163.com>
 */
function get_parent_category($cid)
{
	if (empty($cid)) {
		return false;
	}
	$cates = M('Category')->where(array('status' => 1))->field('id,title,pid')->order('sort')->select();
	$child = get_category($cid);    //获取参数分类的信息
	$pid = $child['pid'];
	$temp = array();
	$res[] = $child;
	while (true) {
		foreach ($cates as $key => $cate) {
			if ($cate['id'] == $pid) {
				$pid = $cate['pid'];
				array_unshift($res, $cate);    //将父分类插入到数组第一个元素前
			}
		}
		if ($pid == 0) {
			break;
		}
	}
	return $res;
}

/**
 * 检测验证码
 *
 * @param  integer $id 验证码ID
 * @param          $code
 *
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1)
{
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * 获取当前分类的文档类型
 *
 * @param int $id
 *
 * @return array 文档类型数组
 * @author huajie <banhuajie@163.com>
 */
function get_type_bycate($id = null)
{
	if (empty($id)) {
		return false;
	}
	$type_list = C('DOCUMENT_MODEL_TYPE');
	$model_type = M('Category')->getFieldById($id, 'type');
	$model_type = explode(',', $model_type);
	foreach ($type_list as $key => $value) {
		if (!in_array($key, $model_type)) {
			unset($type_list[$key]);
		}
	}
	return $type_list;
}

/**
 * 获取当前文档的分类
 *
 * @param int $cate_id
 *
 * @return array 文档类型数组
 * @author huajie <banhuajie@163.com>
 */
function get_cate($cate_id = null)
{
	if (empty($cate_id)) {
		return false;
	}
	$cate = M('Category')->where('id=' . $cate_id)->getField('title');
	return $cate;
}

// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string)
{
	$array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
	if (strpos($string, ':')) {
		$value = array();
		foreach ($array as $val) {
			list($k, $v) = explode(':', $val);
			$value[$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

// 获取子文档数目
function get_subdocument_count($id = 0)
{
	return M('Document')->where('pid=' . $id)->count();
}


// 分析枚举类型字段值 格式 a:名称1,b:名称2
// 暂时和 parse_config_attr功能相同
// 但请不要互相使用，后期会调整
function parse_field_attr($string)
{
	if (0 === strpos($string, ':')) {
		// 采用函数定义
		return eval(substr($string, 1) . ';');
	}
	$array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
	if (strpos($string, ':')) {
		$value = array();
		foreach ($array as $val) {
			list($k, $v) = explode(':', $val);
			$value[$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

/**
 * 获取行为数据
 *
 * @param null $id    行为id
 * @param null $field 需要获取的字段
 *
 * @return bool
 */
function get_action($id = null, $field = null)
{
	if (empty($id) && !is_numeric($id)) {
		return false;
	}
	$list = S('action_list');
	if (empty($list[$id])) {
		$map = array('status' => array('gt', -1), 'id' => $id);
		$list[$id] = M('Action')->where($map)->field(true)->find();
	}
	return empty($field) ? $list[$id] : $list[$id][$field];
}

/**
 * 根据条件字段获取数据
 *
 * @param null   $value     条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param null   $field     需要返回的字段，不传则返回整个数据
 *
 * @return bool
 */
function get_document_field($value = null, $condition = 'id', $field = null)
{
	if (empty($value)) {
		return false;
	}

	//拼接参数
	$map[$condition] = $value;
	$info = M('Model')->where($map);
	if (empty($field)) {
		$info = $info->field(true)->find();
	} else {
		$info = $info->getField($field);
	}
	return $info;
}

/**
 *  获取行为类型
 *
 * @param      $type        类型
 * @param bool $all         是否返回全部类型
 *
 * @return array|mixed
 */
function get_action_type($type, $all = false)
{
	$list = array(
	1 => '系统',
	2 => '用户',
	);
	if ($all) {
		return $list;
	}
	return $list[$type];
}

/**
 * 金额格式化
 *
 * @param $p
 *
 * @return string
 */
function fomatprice($p)
{
	$p = floatval($p);
	if (empty($p)) {
		return '￥0';
	} else {
		$p = number_format($p, 2);
		if (substr($p, -1) == '0') {
			$p = substr($p, 0, -1);
			if (substr($p, -2) == '.0') {
				$p = substr($p, 0, -2);
			}
		}
		return '￥' . $p;
	}
}

/**
 * 金额格式化
 *
 * @param $p
 *
 * @return string
 */
function fomatprice2($p)
{
	return '-';
	$p = floatval($p);
	if (empty($p)) {
		return '-';
	} else {
		$p = number_format($p, 2);
		if (substr($p, -1) == '0') {
			$p = substr($p, 0, -1);
			if (substr($p, -2) == '.0') {
				$p = substr($p, 0, -2);
			}
		}
		return '￥' . $p;
	}
}


function fomatprice1($p)
{
	$p = floatval($p);
	if (empty($p)) {
		return '0';
	} else {
		return '' . $p;
	}
}

/**
 * 判断权限
 *
 * @param       $rule
 * @param array $ids
 * @param       $pid
 *
 * @return bool
 */
function cando($rule, $ids = null)
{
	$access = superrule($rule);
	if ($access === false) {
		return false;
	} elseif ($access === null) {
		if ($ids !== null) {
			if (!cando1($ids)) {
				return false;
			}
		}
		if (!apprule($rule, array('in', '1,2'))) {
			return false;
		} else {
			return true;
		}
	} else {
		return true;

	}
}

function cando1($ids)
{
	if (is_administrator()) {
		return true; // 管理员允许访问任何页面
	}
	if (!in_array(UID, $ids)) {
		return false;
	} else {
		return true;
	}
}

function apprule($rule, $type = AuthRuleModel::RULE_URL, $mode = 'url')
{
	if (IS_ROOT) {
		return true; // 管理员允许访问任何页面
	}
	static $Auth = null;
	if (!$Auth) {
		$Auth = new \Think\Auth ();
	}
	if (!$Auth->check(MODULE_NAME . '/' . $rule, UID, $type, $mode)) {
		return false;
	}
	return true;
}

function superrule($role)
{
	if (is_administrator()) {
		return true; // 管理员允许访问任何页面
	}
	$allow = C('ALLOW_VISIT');
	$deny = C('DENY_VISIT');
	$check = strtolower($role);
	if (!empty ($deny) && in_array_case($check, $deny)) {
		return false;
	}
	if (!empty ($allow) && in_array_case($check, $allow)) {
		return true;
	}
	return null; // 需要检测节点权限
}

function time_formatnew($time = NULL, $format = 'm-d H:i')
{
	if (empty($time)) {
		return '';
	}
	$time = $time === NULL ? NOW_TIME : intval($time);
	return date($format, $time);
}

/**
 * 是否
 *
 * @param $val
 *
 * @return string
 */
function yesorno($val)
{
	$retval = empty($val) ? '否' : '是';
	return $retval;
}

/**
 * 获取编码
 *
 * @param string $string
 * @param  @param object $module 操作的modle
 *
 * @return string
 */
function get_rand_number($string, $module)
{
	$number = $string;
	for ($i = 1; $i < 9; $i++) {
		$number .= rand(1, 9);
	}
	$data = $module->where("code ='" . $number . "'")->find();
	if ($data) {
		get_rand_number($string, $module);
	}
	return $number;
}

/**
 * @param  @param object $module 操作的modle
 *  * @param string $type
 *  * @param int $pro
 *
 * @return string
 */
function get_rand_code($module, $type, $pro = 1)
{
	$date = substr(date('Ym', time()), 2);
	$tmp = M('Code')->field(true)->where("date = $date and type = '$type' and if_pro = $pro")->find();
	if ($tmp) {
		$code = $tmp['code'];
		$code = (int)$code + 1;
		if (strlen($code) == 1) {
			$code = '000' . $code;
		} elseif (strlen($code) == 2) {
			$code = '00' . $code;
		} elseif (strlen($code) == 3) {
			$code = '0' . $code;
		} elseif (strlen($code) == 4) {
			$code = $code;
		} else {
			$code = '0001';
		}
		M('Code')->where('cid = ' . $tmp['cid'])->save(array('code' => $code));
	} else {
		$code = '0001';
		M('Code')->add(array('code' => $code, 'type' => $type, 'if_pro' => $pro, 'date' => $date));
	}

	$number = $type . $date . $code;
	$data = $module->where("code ='" . $number . "'")->find();
	if ($data) {
		get_rand_code($module, $type);
	}
	return $number;
}

//获取文件修改时间
function getfiletime($file, $DataDir)
{
	$a = filemtime($DataDir . $file);
	$time = date("Y-m-d H:i:s", $a);
	return $time;
}

//获取文件的大小
function getfilesize($file, $DataDir)
{
	$perms = stat($DataDir . $file);
	$size = $perms['size'];
	// 单位自动转换函数
	$kb = 1024;         // Kilobyte
	$mb = 1024 * $kb;   // Megabyte
	$gb = 1024 * $mb;   // Gigabyte
	$tb = 1024 * $gb;   // Terabyte

	if ($size < $kb) {
		return $size . " B";
	} else if ($size < $mb) {
		return round($size / $kb, 2) . " KB";
	} else if ($size < $gb) {
		return round($size / $mb, 2) . " MB";
	} else if ($size < $tb) {
		return round($size / $gb, 2) . " GB";
	} else {
		return round($size / $tb, 2) . " TB";
	}
	//处理方法
	function rmdirr($dirname)
	{
		if (!file_exists($dirname)) {
			return false;
		}
		if (is_file($dirname) || is_link($dirname)) {
			return unlink($dirname);
		}
		$dir = dir($dirname);
		if ($dir) {
			while (false !== $entry = $dir->read()) {
				if ($entry == '.' || $entry == '..') {
					continue;
				}
				//递归
				rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
			}
		}
	}

}

/**
 * api通用 生成想要的数据
 *
 * @param $appId
 * @param $appSignKey
 * @param $cost
 *
 * @return mixed
 */
function apiMessage($appId, $appSignKey, $cost)
{
	$public = new \Admin\Controller\PublicController();
	$timestamp = time();
	$nonce = $public->getNonceStr();        // 4

	// 生成签名
	$params = [
        'appId' => $appId,
        'appSignKey' => $appSignKey,
        'timestamp' => $timestamp,
        'nonce' => $nonce,
	];
	// 拼接上其他想要参与签名的参数
	$cost and $params += $cost;

	$sign = $public->msign($params); // 签名   2

	$data['appId'] = $appId;
	$data['sign'] = $sign;
	$data['timestamp'] = $timestamp;
	$data['nonce'] = $nonce;
	$cost and $data += $cost;

	return $data;
}

/**
 * 发送模板
 *
 * @param $data
 * @param $type
 *
 * @return array
 */
function sendTemplate($data, $type,$url)
{
	if (empty($data) || empty($type)) {
		return 1;
	}
	if (empty($data['email'])) {
		return 2;        // 没有邮箱
	}
	$model = M('Dictionary');
	$map['d_code'] = 'msnmodel';
	$map['d_key'] = $type;
	$dic = $model->field('d_value')
	->where($map)
	->find();
	$mess = $dic['d_value'];

	if(empty($mess)){
		return 3;
	}
	$url = 'https://'.$_SERVER['HTTP_HOST'] . '/index.php?s=/Admin/' . $url;
	$data['a'] and $mess = preg_replace('/{.*?}/', "【{$data['a']}】", $mess, 1);
	$data['b'] and $mess = preg_replace('/{.*?}/', "【{$data['b']}】", $mess, 1);
	$data['c'] and $mess = preg_replace('/{.*?}/', "【{$data['c']}】", $mess, 1);
	$cost = [
        'by' => 'email',
        'value' => $data['email'],  //  $data['email']
        'applicationId' => C('APPLICATIONID'),
        'type' => 'text',
        'data' => "<a href='".$url."'>".$mess."</a>",
        'safe' => 'false',
	];

	//echo json_encode($cost);
	//exit();
	return $cost;
}


/*
 * 读取api信息
 *  @param $parameter  得到地址和提交方式(get或post)  : LGW
 *  @param $item  根据项目获取出$appId和$appSignKey
 *  @param $cost  想要拼上的信息  没有则不拼
 * @return mixed
 */
function apiRead($parameter, $item, $cost = '')
{
	if (!is_array($cost) && $cost > 0) {
		return $cost;
	}
	$url = \Admin\Common\Super\Api::getUrl($parameter);
	$appMessage = \Admin\Common\Super\Api::getAppMessage($item);
	$appId = $appMessage['appId'];
	$appSignKey = $appMessage['appSignKey'];
	$apiData = apiMessage($appId, $appSignKey, $cost);
	$result = httpRequest($url['url'], $url['method'], $apiData);
	$result = json_decode($result, true);

	//echo '<br/>';
	//echo json_encode($appMessage).'<br/>';
	//echo json_encode($result).'<br/>';
	//exit();
	return $result;
}


/*
 ** php分别模拟发送GET与POST请求   : LGW
 *
 * @param string $url 地址
 * @param string $method   提交方式(get或post)
 * @param string $param
 *
 * @return mixed
 */

function httpRequest($url, $method, $params = array())
{
	if (trim($url) == '' || !in_array($method, array('get', 'post')) || !is_array($params)) {
		return false;
	}
	$curl = curl_init();
	switch ($method) {
		case 'get':
			$str = '?';
			foreach ($params as $k => $v) {
				$str .= $k . '=' . $v . '&';
			}
			$str = substr($str, 0, -1);
			$url .= $str;//$url=$url.$str;
			curl_setopt($curl, CURLOPT_URL, $url);
			break;
		case 'post':
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			break;
		default:
			$result = '';
			break;
	}
	curl_setopt($curl, CURLOPT_HEADER, 0);// 设置header
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 要求结果为字符串且输出到屏幕上
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // 跳过SSL证书检查
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); // 防止417错误 - 执行失败

	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}


/**
 * 人民币小写转大写
 *
 * @param int    $number        数值
 * @param string $int_unit      币种单位，默认"元"，有的需求可能为"圆"
 * @param bool   $is_round      是否对小数进行四舍五入
 * @param bool   $is_extra_zero 是否对整数部分以0结尾，小数存在的数字附加0,比如1960.30，
 *                              有的系统要求输出"壹仟玖佰陆拾元零叁角"，实际上"壹仟玖佰陆拾元叁角"也是对的
 *
 * @return string
 */
function num2rmb($number = 0, $int_unit = '元', $is_round = TRUE, $is_extra_zero = FALSE)
{
	// 将数字切分成两段
	$parts = explode('.', $number, 2);
	$int = isset($parts[0]) ? strval($parts[0]) : '0';
	$dec = isset($parts[1]) ? strval($parts[1]) : '';

	// 如果小数点后多于2位，不四舍五入就直接截，否则就处理
	$dec_len = strlen($dec);
	if (isset($parts[1]) && $dec_len > 2) {
		$dec = $is_round
		? substr(strrchr(strval(round(floatval("0." . $dec), 2)), '.'), 1)
		: substr($parts[1], 0, 2);
	}

	// 当number为0.001时，小数点后的金额为0元
	if (empty($int) && empty($dec)) {
		return '零';
	}

	// 定义
	$chs = array('0', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
	$uni = array('', '拾', '佰', '仟');
	$dec_uni = array('角', '分');
	$exp = array('', '万');
	$res = '';

	// 整数部分从右向左找
	for ($i = strlen($int) - 1, $k = 0; $i >= 0; $k++) {
		$str = '';
		// 按照中文读写习惯，每4个字为一段进行转化，i一直在减
		for ($j = 0; $j < 4 && $i >= 0; $j++, $i--) {
			$u = $int{$i} > 0 ? $uni[$j] : ''; // 非0的数字后面添加单位
			$str = $chs[$int{$i}] . $u . $str;
		}
		//echo $str."|".($k - 2)."<br>";
		$str = rtrim($str, '0');// 去掉末尾的0
		$str = preg_replace("/0+/", "零", $str); // 替换多个连续的0
		if (!isset($exp[$k])) {
			$exp[$k] = $exp[$k - 2] . '亿'; // 构建单位
		}
		$u2 = $str != '' ? $exp[$k] : '';
		$res = $str . $u2 . $res;
	}

	// 如果小数部分处理完之后是00，需要处理下
	$dec = rtrim($dec, '0');

	// 小数部分从左向右找
	if (!empty($dec)) {
		$res .= $int_unit;

		// 是否要在整数部分以0结尾的数字后附加0，有的系统有这要求
		if ($is_extra_zero) {
			if (substr($int, -1) === '0') {
				$res .= '零';
			}
		}

		for ($i = 0, $cnt = strlen($dec); $i < $cnt; $i++) {
			$u = $dec{$i} > 0 ? $dec_uni[$i] : ''; // 非0的数字后面添加单位
			$res .= $chs[$dec{$i}] . $u;
		}
		$res = rtrim($res, '0');// 去掉末尾的0
		$res = preg_replace("/0+/", "零", $res); // 替换多个连续的0
	} else {
		$res .= $int_unit . '整';
	}
	return $res;
}



/**
 * 去除数组中的空格
 *
 */
function itrim($data)
{
	if (!is_array($data)) {
		return trim($data);
	} else {
		return array_map(function ($v) {
			return itrim($v);
		}, $data);
	}
}

