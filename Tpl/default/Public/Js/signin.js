$(document).ready(function(){
    $('#password').bind('keypress', function(e) {
        if(e.keyCode==13){
           $('#insign').trigger("click");
        }
    });
   });   
     function isValidEmail(str) {
      var regex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
      return regex.test(str);
  }
  
   $('#username').blur(function(){
        var value = $(this).val();
         if(isValidUser(value)) {
            $.ajax({
		   type: "get",
		   url:"/Account/checkusername/?username=" + value,
		   data: "",
		   		   success: function(data){
		   		    if(data == -1) {
                    	$('#signin_msg').empty().append('<font color=red>用户名不存在</font>');
                    }
		   		   },
               error: function(msg){$('#signin_msg').empty().append(msg);}
            });

        }else if(value != ''){
           // showCError(this.id,"无效用户名,用户名长度应该为6-16位");
        }
    });

    function validateForm() {
	 $('#signin_msg').empty();
  

    var value = document.getElementById('password').value;
    if(value == "" || value.length < 4 || value.length > 10) {
        $('#signin_msg').empty().append("密码长度应该为4-10位");
        return false;
    }
    var value = document.getElementById('username').value;
    if(value == "" || value.length < 6 || value.length > 16) {
        $('#signin_msg').empty().append("用户名长度应该为6-16位字母和数字的组合");
        return false;
    }
    

    return true;
}
$('#insign').click(function(){
    if (validateForm()){
       if($('#username').val() != "" && $('#password').val() != ""){
           $.ajax({
                    		   type: "post",
                    		   url:"/Account/checklogin",
                    		   data: $('#signupform').serialize(),
                    		   		   success: function(data){
                    		   		       if (data == 1){
                    		   		           top.location="/";
                    		   		       }else{
                    		   		           $('#signin_msg').empty().append(data);
                    		   		       }
                    		   		   },
                                   error: function(msg){$('#signin_msg').empty().append(msg);}
                                });
  
       }else{
           $('#signin_msg').empty().append("请填写完整");
       }
    }
});
function isValidUser(va){
   if(va == "" || va.length < 6 || va.length > 16) {
        $('#signin_msg').empty().append("用户名长度应该为6-16位字母和数字的组合");
        return false;
    }else{
        $('#signin_msg').empty();
        return true;
    }
}