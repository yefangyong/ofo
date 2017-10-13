$(function(){
   $(document).on('click','#login',function(){
       var userName = $('#username'),
           pwd = $('#password');

       // if(!userName.val()) {
       //     userName.next().show().find('div').text('用户名不得为空');
       //     return ;
       // }
       // if(!pwd.val()) {
       //     pwd.next().show().find('div').text('密码不得为空');
       //     return ;
       // }

       var params = {
           url:'token/app',
           data:{
               ac:userName.val(),
               se:pwd.val()
           },
           type:'post',
           sCallback:function(res) {
               if(res) {
                   window.base.setLocalStorage('token',res.token);
                   window.location.href = "index.html";
               }
           },
           eCallback:function(res) {
               if(res.status == 401) {
                    $('.error-tips').text('帐号或者密码错误').fadeIn().delay(2000).fadeOut();
                   //$('.error-tips').text('账号和密码错误').show().delay(2000).hide();
               }
           }
       };
       window.base.getData(params);
   });

   $(document).on('focus','.normal-input',function(){
       $('common-error-tips').hide();
   });

   $(document).on('keydown','.normal-input',function(e){
       var e = event || window.event || arguments.callee.caller.arguments[0];
       if(e && e.keyCode == 13)  {
           $('#login').trigger('click');
       }
   })
});