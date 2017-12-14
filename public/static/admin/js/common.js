/**
 * 添加
 * @param title
 * @param url
 */
  function edit_add(title,url) {
      var index = layer.open({
          type:2,
          content:url,
          title:title,
      });
      layer.full(index);
  }

/*添加或者编辑缩小的屏幕*/
function yfy_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}

/*
* 提交form表单操作
*
* */
$("#yfycms-button-submit").click(function(){
    var data=$("#yfycms-form").serializeArray();
    console.log(data);
    postData={};
    $(data).each(function(i){
        postData[this.name]=this.value;
    });
    console.log(postData);
    url=SCOPE.save_url;
    jump_url=SCOPE.jump_url;
    $.post(url,postData,function($result){
        if($result.status == 1){
            return dialog.success($result.message,jump_url);
        }else if($result.status == 0){
            return dialog.error($result.message);
        }
    },"JSON");
});

/**
 * 删除操作采用了layer插件和异步加载方式和修改状态公用的方法
 */
$(' .app-status').click(function(){
    var id = $(this).attr('attr-id');
    var message=$(this).attr('attr-message');
    var url = SCOPE.status_url;
    data={};
    data['id'] = id;
    data['status'] = $(this).attr('attr-status');

    layer.open({
        type : 0,
        title : '是否提交？',
        btn : ['yes','no'],
        icon :3,
        closeBtn : 2,
        content : '是否确认'+message,
        scorllbar : true,
        yes: function(){
            todelete(url,data);
        },
    });
});

function todelete(){
    var url = SCOPE.status_url;
    var jump_url = SCOPE.jump_url;
    //ajax的异步操作，交互性好
    $.post(
        url,data,function(s){
            console.log(s);
            if(s.status == 1){
                return dialogs.success(s.message,jump_url);
            }else{
                return dialogs.error(s.message);
            }
        },"JSON");
}

