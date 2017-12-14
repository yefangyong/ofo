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
  
  },

  numberChange:function(e) {
    this.data.bikeID = e.detail.value;
  },

  userBike:function(){
    console.log(this.data.bikeID);
    if (this.data.bikeID == undefined || isNaN(this.data.bikeID)) {
      wx.showModal({
        title: '开锁失败',
        content: '请输入正确的车牌号',
        showCancel: false,
      });
    }else {
      // 正在获取密码通知
      wx.showLoading({
        title: '正在获取密码',
        mask: true
      }),
        wx.request({
          url: 'https://72988837.qcloud.la//index.php/api/v1/bike',
          data: { id: this.data.bikeID },
          method: 'POST',
          success: function (res) {
            // 请求成功隐藏等待框
            wx.hideLoading();
            if (res.statusCode == '401') {
              wx.showModal({
                title: '开锁失败',
                content: res.data.msg,
                showCancel: false,
                confirmText: '确定',
              })
            } else {
              //携带密码和车号跳转到密码页
              console.log(res);
              wx.redirectTo({
                url: '../scanresult/index?password=' + res.data.password + '&number=' + res.data.id,
                success: function (res) {
                  wx.showToast({
                    title: '获取密码成功',
                    duration: 1000
                  });
                }
              });
            }
          }
        });
    }
    
  },
})