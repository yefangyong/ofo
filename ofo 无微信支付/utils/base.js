import {Config} from "config.js";
class Base {
  constructor(){
    this.baseRequestUrl = Config.baseUrl;
  }

//封装好的请求方法
  requet(params) {
    if(!params.type) {
      params.type = "GET";
    }

    wx.request({
      url: this.baseRequestUrl+params.url,
      data: params.data,
      header: {
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      method: params.type,
      success: function(res) {
        sCallBack && sCallBack(res);
      },
      fail: function(res) {
        console.log(res);
      },
      complete: function(res) {},
    })
  }

}
export{Base}