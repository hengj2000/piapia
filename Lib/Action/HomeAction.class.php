<?php

Class HomeAction extends PublicAction {

    public function _initialize() {

    }

    public function index() {
//        $Blog = D("BlogView");
//        $count = $Blog->where("Blog.status=1")->count();
//        $mode = "normal";
//        if (isset($_REQUEST["mode"])) {
//            $mode = $_REQUEST["mode"];
//        }
//        if ($mode == "list") {
//            $listRows = 25;
//        } else {
//            $listRows = 8;
//        }
//        import("@.ORG.Page");
//        $p = new Page($count, $listRows);
//        $p->setConfig("header", "篇日志");
//        $this->assign("mode", $mode);
//        $list = $Blog->order("cTime desc")->limit($p->firstRow . ',' . $p->listRows)->select();dump($list);
//        $page = $p->show();
//        $this->assign("list", $list);
//        $this->assign("page", $page);
//
//        //统计数据
//        $Blog = M("Blog");
//        $stat = array();
//        $stat["beginTime"] = $Blog->min('cTime');
//        $stat["blogCount"] = $Blog->where("status=1")->count();
//        $stat["readCount"] = $Blog->where("status=1")->sum("readCount");
//        $stat["commentCount"] = $Blog->where("status=1")->sum("commentCount");
//        $this->assign($stat);

        $this->display();
    }

 
}

?>