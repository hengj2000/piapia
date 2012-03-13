<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"/><meta name="DESCRIPTION" content="帅哥"/><meta name="KEYWORDS" content="帅哥"/><meta name="ROBOTS" content="ALL"/><link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-iphone4.png" /><link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-ipad.png" /><link rel="apple-touch-icon" href="/apple-touch-icon-iphone.png" /><link rel="shortcut icon" href="/favicon.ico" ><link type="text/css" rel="stylesheet" href="/Tpl/default/Public/css/style.css" /><title>啪啪拍</title><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script><script type="text/javascript" src="/Tpl/default/Public/Js/Ajax/ThinkAjax.js"></script><script type="text/javascript" src="/Tpl/default/Public/Js/Form/CheckForm.js"></script><script language="JavaScript">
            //指定当前组模块URL地址
            var URL = '__URL__';
            var APP	 =	 '__APP__';
            var PUBLIC = '/Tpl/default/Public';
            ThinkAjax.updateTip = '<IMG SRC="/Tpl/default/Public/images/loading2.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="loading..." align="absmiddle"> 数据处理中...';
          
          </script></head><body><div id="topbar"><div id="infobar"><div style="padding-top:3px;float:left" id="logo"><a href="/"><img width="130" border="0" src="/gramfeed_logo_31a.png"></a></div><div style="padding-top:12px;float:right;"><a href="__APP__/Photo/add" class="linkButton" id="link-up">上传</a> | <a href="__APP__/Home/" class="linkButton linkButtonS" id="link-search">浏览</a> | <a href="__APP__/Photo/hot" class="linkButton " id="link-pop">热图</a> | <a href="__APP__/about" class="linkButton">关于</a></div></div><div class="topnav" id="share"><a class="signin link" onclick="logOauth(0)">登录</a></div></div><link type="text/css" rel="stylesheet" href="/Tpl/default/Public/css/smart_upload.css" /><div id="main"><div id="content" style="width: 980px;margin:0 auto"><div style="padding-top: 30px; clear: both;"></div><div class="flashUpload flashUploadExp2 clearfix" style="text-align:center;"><div class="uploadform" id="uploadfrm"><form name="s3_upload" method="post" id="upload" enctype="multipart/form-data" action="__APP__/Photo/Upload" target="iframeUpload"><input type="hidden" name="ajax" value="1"><iframe name="iframeUpload" src="" width="350" height="35" frameborder=0  scrolling="no" style="display:none;" ></iframe><input type="hidden" name="_uploadFileResult" value="result"><input type="hidden" name="_uploadFormId" value="upload"><input type="hidden" name="_uploadFileSize" value="-1"><input type="hidden" name="_uploadResponse" value="uploadComplete"><input type="hidden" name="_uploadFileVerify" value="<?php echo ($verify); ?>"><input type="hidden" name="_uploadFileType" value="jpeg,jpg,gif,png,flv,rm,asf"><input type="hidden" name="_uploadSavePath" value="/Public/Uploads/" ><input type="hidden" name="_uploadImgThumb" value="1"><input type="hidden" name="_uploadThumbMaxWidth" value="200"><input type="hidden" name="_uploadThumbMaxHeight" value="200"><input type="file" name="file"  id="slideshow_pptfile">&nbsp;
  <span onclick="javascript:document.getElementById('upload').submit();" class="button">上传</span></form></div><div id="imgresult"></div><br><div id="result" class="result none"></div><br><div class="uploadform" id="aboutphoto" style="display:none"><form method="post" id="form1" action=""><input type="hidden" name="imgid" value=""><p><label for="tags" class="left">图片标签:</label><input type="text" class="field"  name="tags"><br>(用空格隔开多个标签)</p><p><label for="message" class="left">描述一下:</label><textarea name="contact_message" id="contact_message"  rows="3" tabindex="5"></textarea></p><p><label for="contact_message" class="left"></label><input type="hidden" name="ajax" value="1"><img id="verifyImg" src="__URL__/verify" align="absmiddle">&nbsp;&nbsp;<input type="text" name="verify" class="text small"> 输入验证码 [ <a href="javascript:fleshVerify()">看不清？</a> ] 
                                            </p><p><span onclick="javascript:save()" class="button">提交</span></form></div></div></div></div><script language="JavaScript"><!--
                function addRow(){
                    curFileNum++;
                    rowsnum++;
                    var row=tbl.insertRow(-1);
                    //var td = arow.insertCell();
                    var cell = document.createElement("td");
                    cell.innerHTML='<div class="impBtn  fLeft" ><input type="file" id="file'+curFileNum+'" name="file'+ curFileNum +'" class="file  huge"></div><div class="fLeft hMargin"><img src="../Public/images/del.gif"  style="cursor:hand" onfocus="javascript:getObject(this)" onclick="deleteRow();" width="20" height="20" border="0" alt="删除" align="absmiddle"></div> ';
                    cell.align="center"
                    row.appendChild(cell);
                    //addFileForm.num.value=rowsnum;
                }
                function deleteRow(){
                    if(tbl.rows.length>0){
                        tbl.deleteRow(rindex); //删除当前行
                        rowsnum--;
                    }else{
                        return;
                    }
                    rindex="";
                }
                function getObject(obj){
                    rindex=obj.parentElement.parentElement.rowIndex;/*当前行对象*/
                }

                function uploading(msg){
                    $('#result').style.display = 'block';
                    $('#result').innerHTML = '<img src="/Tpl/default/Public/images/ajaxloading.gif" width="16" height="16" border="0" alt="" align="absmiddle"> 文件上传中～';
                    return true;
                }
                function save(){
                    if ($('file1').value){
                        $('#form1').uploading();
                        $('upload').submit();
                    }else{
                        //document.getElementById('editor').value = KE.html('editor');
                        ThinkAjax.sendForm('form1','__URL__/insert/',doComplete,'result');
                    }
                }
 
                function uploadComplete(objid,objname){
                     //  document.getElementById('editor').value = KE.html('editor');
                  //  ThinkAjax.sendForm('form1','__URL__/insert/',doComplete,'result');
                    //$('upload').reset();
                    if (objid != "" && objname != ""){
                        document.getElementById('uploadfrm').style.display = "none";
                        $('#imgresult').append("<img src='/Public/Uploads/thumb_"+objname+"' border=0>");
                         document.getElementById('aboutphoto').style.display = "";
                         document.getElementById('imgid').value = objid;
                   }
                }
                function doComplete(data,status){
                    if (status==1){
                        window.location.href='__URL__';
                        $('form1').reset();
                        $('upload').reset();
                        fleshVerify();
                    }
                }
                

                function delpp(id){
                   $.ajax({
                		   type: "get",
                		   url: '__URL__/delAttach/id/'+id,
                		   data: "",
		   		   success: function(msg){
		   		       $('#imgresult').empty();
		   		       doFreshpage();
		   		   },
                       error: function(msg){alert(msg);}
                    });

                }
                  function doFreshpage(){
                       //if (status==1){
                           $('#imgresult').empty();
                           $('#result').empty();
                           document.getElementById('uploadfrm').style.display = "";
                           document.getElementById('aboutphoto').style.display = "none";
                     //  }
                  }
                //--></script><script language="JavaScript"></script><script language="javascript" src="/Tpl/default/Public/Js/Common.js" /></script><div style="clear:both;border-bottom:0px dotted #666;border-top:1px dotted #666;padding:15px 0px 15px 0px"></div><div style="clear: both; border-bottom: 0px dotted rgb(102, 102, 102); border-top: 1px dotted rgb(102, 102, 102);" class="text2"><a href="http://www.piapiapai.com" class="link2">啪啪拍</a><a href="#" class="link2"></a></div>