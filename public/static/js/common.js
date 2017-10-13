// window.base={
//     g_restUrl:'http://115.159.6.199/index.php/api/v1/',
//
//     getData:function(params){
//         if(!params.type){
//             params.type='get';
//         }
//         var that=this;
//         $.ajax({
//             type:params.type,
//             url:this.g_restUrl+params.url,
//             data:params.data,
//             beforeSend: function (XMLHttpRequest) {
//                 if (params.tokenFlag) {
//                     XMLHttpRequest.setRequestHeader('token', that.getLocalStorage('token'));
//                 }
//             },
//             success:function(res){
//                 console.log(res);
//                 params.sCallback && params.sCallback(res);
//             },
//             error:function(res){
//                 console.log(res);
//                 params.eCallback && params.eCallback(res);
//             }
//         });
//     },
//
//     setLocalStorage:function(key,val){
//         var exp=new Date().getTime()+2*24*60*60*100;  //令牌过期时间
//         var obj={
//             val:val,
//             exp:exp
//         };
//         //将json数据转化为字符串，放到缓存中
//         localStorage.setItem(key,JSON.stringify(obj));
//     },
//
//     getLocalStorage:function(key){
//         var info= localStorage.getItem(key);
//         if(info) {
//             info = JSON.parse(info);
//             if (info.exp > new Date().getTime()) {
//                 return info.val;
//             }
//             else{
//                 this.deleteLocalStorage('token');
//             }
//         }
//         return '';
//     },
//
//     deleteLocalStorage:function(key){
//         return localStorage.removeItem(key);
//     },
//
// }

window.base = {
    g_resultUrl:'http://www.problem.com/index.php/api/v1/',

    getData:function(params) {

        if(!params.type) {
            params.type = 'Get';
        }
        var that = this;

        $.ajax({
            url:this.g_resultUrl+params.url,
            type:params.type,
            data:params.data,
            beforeSend:function(XMLHttpRequest) {
                if(params.tokenFlag) {
                    XMLHttpRequest.setRequestHeader('token',that.getLocalStorage('token'));
                }
            },
            success:function(res) {
                params.sCallback && params.sCallback(res);
            },
            error:function(e){
                params.eCallback && params.eCallback(e);
            }
        })
    },

    setLocalStorage:function(key,val) {
        var exp = new Date().getTime() + 2*24*60*60*100;

        var obj = {
            exp:exp,
            val:val
        };

        localStorage.setItem(key,JSON.stringify(obj));
    },

    getLocalStorage:function(key) {

        var info = localStorage.getItem(key);

        info = JSON.parse(info);

        if(info.exp > new Date().getTime()) {
            return info.val;
        }else {
            this.deleteLocalStorage(key);
        }
        return '';
    },

    deleteLocalStorage:function(key) {
        return localStorage.removeItem(key);
    }
}
