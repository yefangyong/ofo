// pages/charge/index.js
Page({
  data:{
    inputValue: 0
  },
// 页面加载
  onLoad:function(options){
    console.log(options);
    this.setData({
      from: options.from
    })
    wx.setNavigationBarTitle({
      title: '充值'
    })
  },
// 存储输入的充值金额
  bindInput: function(res){
    this.setData({
      inputValue: res.detail.value
    })  
  },
// 充值
  charge: function(){
    // 必须输入大于0的数字
    var that = this;
    if(parseInt(this.data.inputValue) <= 0 || isNaN(this.data.inputValue)){
      wx.showModal({
        title: "警告",
        content: "请输入金额",
        showCancel: false,
        confirmText: "确定"
      })
    }else{
      var token = wx.getStorageSync('token');
        wx.request({
          url: 'https://72988837.qcloud.la/index.php/api/v1/user/pay',
          method: 'post',
          data: {
            from:this.data.from,
            price: this.data.inputValue,
          },
          header: {
            'token': token
          },
          success: function (rel) {
            if(that.data.from == 'index') {
              wx.setStorageSync('guarantee', that.data.inputValue);
              wx.switchTab({
                url: '../index/index',
                success:function(res){
                  wx.showToast({
                    title: "充值成功",
                    icon: "success",
                    duration: 2000
                  });
                }
              })
            }else if(that.data.from == 'wallet') {
              var balance = wx.getStorageSync('balance');
              var price = parseFloat(that.data.inputValue) + parseFloat(balance);
              wx.setStorageSync('balance', price);
              wx.redirectTo({
                url: '../wallet/index',
                success: function (res) {
                  wx.showToast({
                    title: "充值成功",
                    icon: "success",
                    duration: 2000
                  });
                }
              });
            }else if(that.data.from == 'pay'){
              var balance = wx.getStorageSync('balance');
              var price = parseFloat(that.data.inputValue) +parseFloat(balance);
              wx.setStorageSync('balance', price);
              wx.showToast({
                title: "充值成功",
                icon: "success",
                duration: 10000,
                success:function(res) {
                  wx.navigateBack({
                    delta: 1,
                  })
                }
              });
                }
          }
        }); 
    }
  },
// 页面销毁，更新本地金额，（累加）
  onUnload:function(){
    wx.getStorage({
      key: 'overage',
      success: (res) => {
        wx.setStorage({
          key: 'overage',
          data: {
            overage: parseInt(this.data.inputValue) + parseInt(res.data.overage)
          }
        })
      },
      // 如果没有本地金额，则设置本地金额
      fail: (res) => {
        wx.setStorage({
          key: 'overage',
          data: {
            overage: parseInt(this.data.inputValue)
          },
        })
      }
    }) 
  }
})