// index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var times = options.times;
    var price = Math.ceil(times/3600);
    var bikeID = options.bikeID;
    this.setData({
      price:price,
      bikeID:bikeID
    });
  },

  pay:function(){
    var that = this;
    if ((wx.getStorageSync('balance')-this.data.price)>=0){
      wx.request({
        url: 'https://30166482.qcloud.la/index.php/api/v1/user/record',
        method: 'post',
        header: {
          token: wx.getStorageSync('token')
        },
        data: {
          'start_time': wx.getStorageSync('start_time'),
          'end_time': wx.getStorageSync('end_time'),
          'start_long': wx.getStorageSync('start_long'),
          'start_lati': wx.getStorageSync('start_lati'),
          'end_long': wx.getStorageSync('end_long'),
          'end_lati': wx.getStorageSync('end_lati'),
          'price': this.data.price,
          'bikeID': this.data.bikeID
        },
        success: function (res) {
          //更新余额的缓存
          var balance = wx.getStorageSync('balance');
          var price =balance - that.data.price;
          wx.setStorageSync('balance', price);
          //清除时间和位置的缓存
          wx.removeStorageSync('end_time');
          wx.removeStorageSync('start_time');
          wx.removeStorageSync('start_long');
          wx.removeStorageSync('start_lati');
          wx.removeStorageSync('end_long');
          wx.removeStorageSync('end_lati');
          wx.showToast({
            title: '支付成功',
            icon: 'success',
            duration: 6000,
            success: function(res) {
              wx.switchTab({
                url: '../index/index',
              })
            },

          })
        }
      });
    }else {
      wx.showModal({
        title: '支付失败',
        content: '您的余额不足，请先充值',
        success: function(res) {
          wx.navigateTo({
            url: '../charge/index?from=pay',
          })
        },
        
      })
    }
    
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})