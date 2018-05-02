<?php
namespace Admin\Controller;
class BakController extends AdminController {
	
	private $db;
	private $DataDir;
	//构造函数 实例化ModuleModel 并获得整张表的数据
	public function __construct(){
		parent::__construct();
		//初始化时实例化category model
		$this->db=D('Backup');
		$this->DataDir = "C:\workspace\php\gm\Public\UPLOAD";
	}
	public function index(){
		$lists = $this->lists( M('Backup'));
		$root_mbx=array();
		$root_mbx[]=array('title'=>'管理','url'=>U('Action/index'));
		$root_mbx[]=array('title'=>'数据备份','url'=>'');
		$this->assign('root_mbx',$root_mbx);
		$this->assign("lists", $lists);
		$this->display();
	}
	//备份
	public function backup(){
		$DataDir = $this->DataDir;
		mkdir($DataDir);

		import("Common.Org.MySQLReback");
        $path = C('DATA_BASE');
        $database = include "$path";
		$config = array(
			'host' => $database['DB_HOST'],
			'port' => $database['DB_PORT'],
			'userName' => $database['DB_USER'],
			'userPassword' => $database['DB_PWD'],
			'dbprefix' => $database['DB_PREFIX'],
			'charset' => 'UTF8',
			'path' => $DataDir,
			'isCompress' => 0, //是否开启gzip压缩
			'isDownload' => 0
		);
		$mr = new MySQLReback($config);
		$mr->setDBName($database['DB_NAME']);
		$id = $mr->backup();
		action_log_new(array('outtype' => 'ot_backup','outkey' => $id,'action' => 'create','comment' => '备份'));
		echo "<script>window.location.href='" . U("Bak/index") . "'</script>";
	}
	
	//还原
	public function rl(){
		$id = I('get.id');
		if(!$id){
			$this->ajaxReturn(array('done' => true, 'msg' => "请选择操作的数据"));
		}
		if(IS_POST){
			$back = $this->db->where("id = {$id}")->find();
			$DataDir = $this->DataDir;
			$content = I('content')?:'';
			$xxx = I('get.xxx');
			import("Common.Org.MySQLReback");
			$config = array(
				'host' => C('DB_HOST'),
				'port' => C('DB_PORT'),
				'userName' => C('DB_USER'),
				'userPassword' => C('DB_PWD'),
				'dbprefix' => C('DB_PREFIX'),
				'charset' => 'UTF8',
				'path' => $DataDir,
				'isCompress' => 0, //是否开启gzip压缩
				'isDownload' => 0
			);
			$mr = new MySQLReback($config);
			$mr->setDBName(C('DB_NAME'));
			if($xxx == 2){
				$mr->recover($back['name']);
			}else if($xxx ==1){
				if($mr->backup()){
					$mr->recover($back['name']);
				}
			}
			M()->execute("update ot_backup set rlnum = rlnum+1 where name = '".$back['name']."'");
			action_log_new(array('outtype' => 'ot_backup','outkey' => $id,'action' => 'update','comment' => $content));
			echo "<script>window.parent.choose()</script>";
		}else{
			$this->assign('id',$id);
			$this->display();
		}
		
	}
	//下载
	public function download(){
		$id = I('id');
		$back = $this->db->where("id = {$id}")->find();
		$fileName = $back['name'];
		$fileName = $this->DataDir . $fileName;
		$this->DownloadFile($fileName);
		exit();
	}
	/*删除备份*/
	public function delete() {
		$ids = ( array ) I ( 'id', 0 );
		if (empty ( $ids )) {
			$this->error ( '请选择要操作的数据!' );
		}
		foreach($ids as $vo){
			$task =$this->db->where("id = {$vo}")->find();
			$this->db->where("id = {$vo}")->delete();
			@unlink($this->DataDir . $task['name']);
			action_log_new(array('outtype' => 'ot_backup','outkey' => $vo,'action' => 'delete','comment' => '删除备份'));
		}
		$this->success ( "删除成功");
	}
	public function  DownloadFile($fileName) {
			ob_end_clean();
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Length: ' . filesize($fileName));
			header('Content-Disposition: attachment; filename=' . basename($fileName));
			readfile($fileName);
		}

}
