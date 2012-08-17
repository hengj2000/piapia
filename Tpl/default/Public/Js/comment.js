function savecommt(){
 var cm = $('#comm').val();
 var cid = $('#cid').val();
 $.ajax({
		   type: "post",
		   url: "/Topic/savecomment",
		   data: "comment="+cm+"&cid="+cid,
		   		   success: function(msg){
		   		  
		   		  $('.lzl_main_wrapper').append(msg);
		   		   },
   error: function(msg){alert(msg);}
});


}