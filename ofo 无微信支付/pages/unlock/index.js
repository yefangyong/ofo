// index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    type:'scan'
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },
  scan:function() {
      wx.scanCode({
        success: (res) => {
          // 正在获取密码通知
          wx.showLoading({
            title: '正在获取密码',
            mask: true
          })
          // 请求服务器获取密码和车号
          wx.request({
            url: 'https://www.easy-mock.com/mock/59098d007a878d73716e966f/ofodata/password',
            data: {},
            method: 'GET', 
            success: function(res){
              // 请求密码成功隐藏等待框
              wx.hideLoading();
              // 携带密码和车号跳转到密码页
              wx.redirectTo({
                url: '../scanresult/index?password=' + res.data.data.password + '&number=' + res.data.data.number,
                success: function(res){
                  wx.showToast({
                    title: '获取密码成功',
                    duration: 1000
                  })
                }
              })           
            }
          })
        }
      })
  },

  changeType:function() {
    wx.redirectTo({
      url: '../input/index',
    })
    
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