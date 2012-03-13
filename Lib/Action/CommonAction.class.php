<?php
//后台方法基类 所有方法继承此类
class CommonAction extends Action {
	function _initialize() {            
	     
    
 
	}       
        
	/**
     +----------------------------------------------------------
     * 页面跳转
     +----------------------------------------------------------
     * @param string $path 跳转到得地址
	 * @param $result 判断值
	 * @param string $successtxt 判处成功提示文本
	 * @param string $errortxt 判处失败提示文本
     +----------------------------------------------------------
     */
	protected function jumpUrl($path,$result,$successtxt,$errortxt,$dolog){
			if($result){
			    if(is_array($path)){$path = $path['s'];}
				if(is_array($dolog)){
				    $this->logInDb(1,MODULE_NAME."/".ACTION_NAME,$dolog[0]);
				}
				$this -> assign('jumpUrl',$path);
			    $this -> success($successtxt,1);
			}else{
			    if(is_array($path)){$path = $path['e'];}
				if(is_array($dolog)){
				    $this->logInDb(0,MODULE_NAME."/".ACTION_NAME,"",$dolog[1]);
				}
				$this -> assign('jumpUrl',$path);
			    $this -> error($errortxt,3);
			}	
	}
	/**
     +----------------------------------------------------------
     * 数据分页
     +----------------------------------------------------------
	 * @param int $type 1单表查询 2多表查询
	 * @param array $data $data['pagesize']默认分页条数 $data['table']单表查询使用的数据表 $data['sql']表查询使用,$data['sql']['count']查询总数语句,$data['sql']['all']查询需要的字段
	 * @param array $condition 条件
     +----------------------------------------------------------
     */
	protected function showPage($type,$data,$condition){
		
		if(empty($data['pagesize'])){
			$pageSize = C('PAGENUM');//获取默认分页数量
		}else{
		    $pageSize = $data['pagesize'];
		}
		if($type == 1){
			$M = M($data['table']);
		}else{
			$M = new Model();
		}
		
		import("ORG.Util.Page"); // 导入分页类
	    if($type == 1){
			if(!empty($condition)){
				$count = $M->where($condition)->count(); // 查诟满足要求癿总记录数
			}else{
				$count = $M->count(); // 查诟满足要求癿总记录数
			}
	    }else{
			$count = $M->query($data['sql']['count']);
			$count = $count[0]['COUNT'];
		}
        $Page = new Page($count,$pageSize); // 实例化分页类 传入总记录数和每页显示癿记录数
		//设置分页显示样式
        $Page->setConfig("nowpagecss","am_fyxzzt");
        $Page->setConfig("theme","<div class='am_fyys'><span>%first% %prePage% %upPage% %linkPage% %downPage% %nextPage% %end%</span><small>共%totalRow%%header% 第%nowPage%/%totalPage%页 %pagenav%</small></div>");
        $show = $Page->show(); // 分页显示输出
		if($type == 1){
			if(!empty($data['order'])){
				$order = $data['order'];
			}
			if(!empty($data['field'])){
				$field = $data['field'];
			}else{
				$field = '*';
			}
			if(!empty($condition)){
				$list = $M->where($condition)->field($field)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
			}else{
				$list = $M->order($order)->field($field)->limit($Page->firstRow.','.$Page->listRows)->select();
			}
		}else{
			$listRows = $Page->listRows+1;
			$firstRow = $Page->firstRow;
			if($firstRow > 0){ $listRows = $listRows + $firstRow; }
			$list = $M->query("select * from (select rownum rn , a.* from ({$data['sql']['all']}) a where rownum < {$listRows}) where rn > {$firstRow}");//多表查询
		}
		
		$this->assign('list',$list); // 赋值数据集
		if($count > $pageSize){
            $this->assign('page',$show); //赋值分页输出
		}
	     return $list;
	}
	/**
     +----------------------------------------------------------
     * 检查空数据
     +----------------------------------------------------------
	 * @param string or array $data 需要检查的数据
     * @param string $url 检查到数据错误要跳转的url
	 * @param string $url 检查到数据错误要跳转的url
     +----------------------------------------------------------
     */
	protected function checkEmptyData($data,$url){
		if(is_array($data)){
			foreach($data as $key=>$v){
				$newdata[$key] = trim($v);
				if(trim($v) == ''){
					$this -> assign('jumpUrl',$url);
			        $this -> error('数据必须填写完整！');
				}
			}
		}else{
			$newdata = trim($data);
			if($newdata == ''){
				$this -> assign('jumpUrl',$url);
				$this -> error('数据必须填写完整！');
			}
		}
		return $newdata;
	}
	/**
     +----------------------------------------------------------
     * 检查空数据与数据类型 默认检查空数据 如果不检查某些字段空数据先unset
     +----------------------------------------------------------
	 * @param string or array $data 需要检查的数据
     * @param string $url 检查到数据错误要跳转的url
	 * @param array $field 要检查的数据 二维数据结构
	 * 格式$_POST = $this->checkData($_POST,$jump,array(array("name"=>"lpname","type"=>1),array("name"=>"lporder","type"=>2)));
     +----------------------------------------------------------
     */
	protected function checkData($data,$url,$field){
		if(is_array($data)){
			foreach($data as $key=>$v){
				$v = trim($v);
				$newdata[$key] = $v;
				if($v == ''){
					$this -> assign('jumpUrl',$url);
			        $this -> error('数据必须填写完整！');
				}
				if(is_array($field)){
					foreach($field as $m){
						if($m['name'] == $key){
							if($m['type'] == 1 && $key == $m['name']){//验证邮件地址
								if(!preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('邮箱格式错误，请仔细检查！');
								}
							}elseif($m['type'] == 2 && $key == $m['name']){//验证电话号码
								if(!preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('电话号码格式错误，请仔细检查！');
								}
							}elseif($m['type'] == 3 && $key == $m['name']){//验证邮编
								if(!preg_match("/^[1-9]\d{5}$/",$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('邮编格式错误，请仔细检查！');
								}
							}elseif($m['type'] == 4 && $key == $m['name']){//验证url地址
								if(!preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('url地址格式错误，请仔细检查！');
								}
							}elseif($m['type'] == 5 && $key == $m['name']){//验证身份证号码
								if(!preg_match('/(^([\d]{15}|[\d]{18}|[\d]{17}x)$)/',$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('身份证号码格式错误，请仔细检查！');
								}
							}elseif($m['type'] == 6 && $key == $m['name']){//验证纯英文
								if(!preg_match("/^[A-Za-z]+$/",$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('不是纯英文字母，请仔细检查！');
								}
							}elseif($m['type'] == 7 && $key == $m['name']){//验证手机
								if(!preg_match("/^((\(\d{3}\))|(\d{3}\-))?13\d{9}$/",$v)){
									$this -> assign('jumpUrl',$url);
									$this -> error('手机号码格式错误，请仔细检查！');
								}
							}
						}
					}
				}
			}
		}else{
			$newdata = trim($data);
			if($newdata == ''){
				$this -> assign('jumpUrl',$url);
				$this -> error('数据必须填写完整！');
			}
		}
		return $newdata;
	}
	/**
     +----------------------------------------------------------
     * 再插入/修改时，检查某个表的某字段值是否重复
     +----------------------------------------------------------
     * @param array $condition $condition['table'] 表名 $condition['key'] 要检查的字段 $condition['val'] 要检查值
     * @param array $conArr 修改时 过滤掉自身 $conArr['key'] 根据该字段过滤 $conArr['val'] 字段值
     * 
     * @不存在返回 0 存在 返回重复的个数
     +----------------------------------------------------------
     */
	function checkUnqiue($condition,$conArr="")
	{
                        $M = M($condition['table']);                                     
                        $cond[$condition['key']] =  array('eq',$condition['val']);
                        if($conArr)
                        {
                            $cond[$conArr['key']] = array('neq',$conArr['val']);
                         }
//                        $num = $M->where($condition['key']."='".$condition['val']."'")->count();
                         $num = $M->where($cond)->count();
                        return $num;
	}

    /**
     +----------------------------------------------------------
     * 上传文件
     +----------------------------------------------------------
	 * @param array or array $data['path'] 路径 $data['fname']文件     主要参数
     +----------------------------------------------------------
     */
	protected function updateDate($data){
		import("ORG.Net.UploadFile");  //引入UploadFile类
		$upload = new UploadFile(); // 实例化上传类   
		$upload->savePath = $data['path'];
		$upload->allowExts  = array('mp3','wma','lrc','jpg','png','gif'); // 设置附件上传类型   
		$upload->autoSub = true; //设置是否开启子目录保存文件
		$upload->subType = date; //设置子目录保存格式方法 
		$upload->saveRule='uniqid'; //设置文件保存格式
		if($data['fname']){
		    $up = $upload->uploadOne($data['fname'],$data['path']);
			return $up;
		}else{
			if (!$upload->upload()) {
				//捕获上传异常
				$this->error($upload->getErrorMsg());
			} else {
				$uploadList = $upload->getUploadFileInfo();
				return $uploadList;
			}
		}
	}

	 /**
     +----------------------------------------------------------
     * 上传图片
     +----------------------------------------------------------
	 * @param array $file 上传图片的信息
	 * @param str $savepath 保存路径	 
	 * @param int $type 1单个图片上传并生成缩略图 
						2单个图片上传不生成缩略图  
						3多张图片上传  
     +----------------------------------------------------------
     */
	protected function uploadPic($file,$savepath,$type=1,$width=73,$width=73){
		if(empty($file) || empty($savepath)) return false;

		$up = array();
		import("ORG.Net.UploadFile");  //引入UploadFile类
		$upload = new UploadFile(); // 实例化上传类   
		$upload->savePath = $savepath;
		$upload->allowExts  = array('jpg','png','gif','jpeg'); // 设置附件上传类型   
		$upload->autoSub = true; //设置是否开启子目录保存文件
		$upload->subType = date; //设置子目录保存格式方法 
		$upload->saveRule='uniqid'; //设置文件保存格式
		
		if($type < 3){
			if($type == 1){
				$upload->thumb = true;
				$upload->thumbMaxWidth = $width;
				$upload->thumbMaxHeight = $width;
				$upload->thumbPath = $savepath.date('Ymd').'/';
				$upload->thumbPrefix = '';
				$upload->thumbSuffix = '_s';
			}

			$up = $upload->uploadOne($file);
                                                        if(!$up){
                                                                 return  $upload->getErrorMsg();
                                                        }

			if($up && $type == 1){
				$up = $up[0];
				$tmp   = explode('/',$up['savename']);
				$fs    = explode('.',$tmp[1]);
				$up['smailpic'] = $tmp[0].'/'.$fs[0].$upload->thumbSuffix.'.'.$fs[1];
				if(!is_file($up['savepath'].$up['smailpic']) || !is_file($up['savepath'].$up['savename'])){
					unlink($up['savepath'].$up['smailpic']);
					unlink($up['savepath'].$up['savename']);
				}
			}
			return $up;
		}else{
			foreach($file as $value0){
				$tmp[] = $upload->uploadOne($value0);			
			}
			if($tmp){
				foreach($tmp as $value1) {
					$up[] = $value1[0]['savename'];	
				}
			}
			return $up;
		}
		return false;
	}


	//搜索数据格式化
	protected function serchData($data){
	    if(is_array($data)){
		    $where = '1=1';
			foreach($data as $v){
			    if($v['stype'] == 'like'){
				    $_GET[$v['name']] = preg_replace("/([a-z])\'([a-z])/","$1''$2",$_GET[$v['name']]);
				    $sval = "{$v['sname']} LIKE '%{$_GET[$v['name']]}%'";
				}elseif($data['stype'] == '>'){
				    $sval = "{$v['sname']} > {$v['tval']}";
				}elseif($data['stype'] == '<'){
				    $sval = "{$v['sname']} < {$v['tval']}";
				}else{
				    $sval = "{$v['sname']} = {$_GET[$v['name']]}";
				}
				if($_GET[$v['name']] != '' || !empty($_GET[$v['name']])){
					$where .= " AND {$sval}";
				}
			}
			$this -> assign('data',$_GET);
			return $where;
		}
	}

        
}

?>
