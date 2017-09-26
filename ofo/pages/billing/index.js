import {Base} from '../../utils/base.js';
var base = new Base();
Page({
  data:{
    hours: 0,
    minuters: 0,
    seconds: 0,
    billing: "正在计费"
  },
// 页面加载
  onLoad:function(options){
    console.log(options.number);
    //改变单车的状态
    var params = {
      url:'bike/status',
      method:'post',
      data:{
        id:options.number
      }
    };
    base.request(params);
    wx.setStorageSync('time', true);
    // 获取车牌号，设置定时器
    this.setData({
      number: options.number,
      timer: this.timer
    })
    // 初始化计时器
    let s = 0;
    let m = 0;
    let h = 0;

    //获取开始的时间
    
    var tmp = Date.parse(new Date()).toString();
    tmp = tmp.substr(0, 10);
    wx.setStorageSync('start_time', tmp);
    // 计时开始
    this.timer = setInterval(() => {
      this.setData({
        seconds: s++
      })
      if(s == 60){
        s = 0;
        m++;
        setTimeout(() => {         
          this.setData({
            minuters: m
          });
        },1000)      
        if(m == 60){
          m = 0;
          h++
          setTimeout(() => {         
            this.setData({
              hours: h
            });
          },1000)
        }
      };
    },1000)  
  },
// 结束骑行，清除定时器
  endRide: function(){
    //结束时间
    var tmp = Date.parse(new Date()).toString();
    tmp = tmp.substr(0, 10);
    wx.setStorageSync('end_time', tmp);
    //结束位置
    // 2.获取并设置当前位置经纬度
    wx.getLocation({
      type: "gcj02",
      success: (res) => {
        console.log(res);
        wx.setStorageSync('end_long', res.longitude);
        wx.setStorageSync('end_lati', res.latitude);
      }
    });
    var times = (this.data.minuters * 60 + this.data.hours * 3600 + this.data.seconds);
    wx.setStorageSync('time', false)
    clearInterval(this.timer);
    this.timer = "";
    this.setData({
      billing: "本次骑行耗时",
      disabled: true
    });
    setTimeout(()=>{
      wx.navigateTo({
        url: '../pay/index?times='+times+"&bikeID="+this.data.number,
      });
    },2000);
  },
// 携带定时器内容回到地图
  moveToIndex: function(){
    // 如果定时器为空
    if(this.timer == ""){
      // 关闭计费页跳到地图
      wx.switchTab({
        url: '../index/index'
      })
    // 保留计费页跳到地图
    }else{
      wx.switchTab({
        url: '../index/index?timer=' + this.timer
      })
    }
  }
})