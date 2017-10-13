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

