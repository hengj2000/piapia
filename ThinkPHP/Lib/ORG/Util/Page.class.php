<?php
// +----------------------------------------------------------------------
// | 分页类
// +----------------------------------------------------------------------
// | time:2011-08-11
// +----------------------------------------------------------------------

class Page extends Think {
    // 起始行数
    public $firstRow;
    // 列表每页显示行数
    public $listRows;
    // 页数跳转时要带的参数
    public $parameter;
    // 分页总页面数
    protected $totalPages;
    // 总行数
    protected $totalRows;
    // 当前页数
    protected $nowPage;
    // 分页的栏的总页数
    protected $coolPages;
    // 分页栏每页显示的页数
    protected $rollPage;
	// 分页显示定制
    protected $config = array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'首页','last'=>'末页','nowpagecss'=>'','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows,$parameter='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->rollPage = C('PAGE_ROLLPAGE');
        $this->listRows = !empty($listRows)?$listRows:C('PAGE_LISTROWS');
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->nowPage  = !empty($_GET[C('VAR_PAGE')])?$_GET[C('VAR_PAGE')]:1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = C('VAR_PAGE');
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a href='".$url."&".$p."=$upRow'><i></i><em>".$this->config['prev']."</em><u></u></a>";
        }else{
            $upPage="";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a href='".$url."&".$p."=$downRow'><i></i><em>".$this->config['next']."</em><u></u></a>";
        }else{
            $downPage="";
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
            $prePage = "<a href='".$url."&".$p."=$preRow' ><i></i><em>上".$this->rollPage."页</em><u></u></a>";
            $theFirst = "<a href='".$url."&".$p."=1' ><i></i><em>".$this->config['first']."</em><u></u></a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "<a href='".$url."&".$p."=$nextRow' ><i></i><em>下".$this->rollPage."页</em><u></u></a>";
            $theEnd = "<a href='".$url."&".$p."=$theEndRow' ><i></i><em>".$this->config['last']."</em><u></u></a>";
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "<a href='".$url."&".$p."=$page'><i></i><b>".$page."</b><u></u></a>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "<a href='#' class='".$this->config['nowpagecss']."'><i></i><b id='".$this->config['nowpagecss']."'>".$page."</b><u></u></a>";
                }
            }
        }
		$pagenav = '<select onchange=\'window.location="' . $url . '&p="+this.value\'>';
		for ($i = 1; $i <= $this->totalPages; ++$i) {
			$selected = ($i == $this->nowPage ? 'selected' : '');
			$pagenav .= '' . '<option value=\'' . $i . '\' ' . $selected . '>' . $i . '</option>';
		}
		$pagenav .= "</select>";
		
		$nextRow = $this->nowPage+$this->rollPage;
        $theEndRow = $this->totalPages;
		$theFirst = "<a href='".$url."&".$p."=1' ><i></i><em>".$this->config['first']."</em><u></u></a>";
		$theEnd = "<a href='".$url."&".$p."=$theEndRow' ><i></i><em>".$this->config['last']."</em><u></u></a>";
		//_e($linkPage);
        $pageStr = str_replace(array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%','%pagenav%'),array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd,$pagenav),$this->config['theme']);
		return $pageStr;
    }

}
?>