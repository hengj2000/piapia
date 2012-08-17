$(document).ready(function(){
    $('#password').bind('keypress', function(e) {
        if(e.keyCode==13){
          
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
		   		    if(data == 1) {
                    	$('#signin_msg').empty().append('<font color=red>用户名已经被注册</font>');
                    }
		   		   },
               error: function(msg){$('#signin_msg').empty().append(msg);}
            });

        }else if(value != ''){
           // showCError(this.id,"无效用户名,用户名长度应该为6-16位");
        }
    });
    	$('#email').blur(function(){
        var value = $(this).val();
        if(value != '' && !isValidEmail(value)){
        	$('#signin_msg').empty().append("无效邮箱");
        }
    });
    function validateForm() {
	 $('#signin_msg').empty();
    var value = document.getElementById('email').value;

    if(!isValidEmail(value)) {
        $('#signin_msg').empty().append("无效email");
        return false;
    } 
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

$('#singup').click(function() {
    	$('#signin_msg').empty();
    	if(validateForm()){//SignupForm
    	   $.ajax({
		   type: "get",
		    url:"/Account/checkemail/?email=" + $('#email').val(),
		   		   success: function(data){
		   		   if(data == 1) {
                    	$('#signin_msg').empty().append('<font color=red>邮箱已经被注册</font>');
                    } else {
                        var go = checkusername();
                        if (go){
                             $.ajax({
                    		   type: "post",
                    		   url:"/Account/create",
                    		   data: $('#signupform').serialize(),
                    		   		   success: function(data){
                    		   		         top.location="/";
                    		   		   },
                                   error: function(msg){$('#signin_msg').empty().append(msg);}
                                });
                       }else{
                          //$('#signin_msg').empty().append('<font color=red>用户名格式错误或者已经被注册</font>');
                       }
                    }
		   		   },
           error: function(msg){alert(msg);}
        });
    	} 
    });
    function checkusername(){
       var value = $('#username').val();
        $('#signin_msg').empty();
       var falg = false;
        if(isValidUser(value)) {
            $.ajax({
		   type: "get",
		   url:"/Account/checkusername",
		   data: "username=" + value,
		   async:false,
		   		   success: function(ret){
		   		    if((ret) == 1) {
		   		        falg = false;
                    	$('#signin_msg').empty().append('<font color=red>用户名已经被注册</font>');
                    	// return falg;
		   		    }
		   		    if((ret) == -1) {
                         falg = true;
                         //return falg;
                    }
		   		   },
               error: function(msg){alert(msg);}
            });
        }
       return falg;
}
function isValidUser(va){
   if(va == "" || va.length < 6 || va.length > 16) {
        $('#signin_msg').empty().append("用户名长度应该为6-16位字母和数字的组合");
        return false;
    }else{
        $('#signin_msg').empty();
        return true;
    }
}