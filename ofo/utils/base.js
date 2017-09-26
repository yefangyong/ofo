import {Config} from "config.js";
class Base {
  constructor(){
    this.baseRequestUrl = Config.baseUrl;
  }

//封装好的请求方法
  request(params) {
    if(!params.method) {
      params.method = "GET";
    }

    wx.request({
      url: this.baseRequestUrl+params.url,
      data: params.data,
      header: {
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      method: params.method,
      success: function(res) {
        params.sCallBack && params.sCallBack(res);
      },
      fail: function(res) {
       eCallBack && eCallBack(res);
      },
      complete: function(res) {},
    })
  }

}
export{Base}