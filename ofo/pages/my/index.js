// pages/my/index.js
import { Base } from '../../utils/base.js';
var base = new Base();
Page({
  data:{
    // 用户信息
    from:'personal',
    userInfo: {
      avatarUrl: "",
      nickName: "未登录"
    },
    bType: "primary", // 按钮类型
    actionText: "登录", // 按钮文字提示
    lock: false //登录按钮状态，false表示未登录
  },
// 页面加载
  onLoad:function(){
    // 设置本页导航标题
    wx.setNavigationBarTitle({
      title: '个人中心'
    })
    // 获取本地数据-用户信息
    wx.getStorage({
      key: 'userInfo',
      // 能获取到则显示用户信息，并保持登录状态，不能就什么也不做
      success: (res) => {
        wx.hideLoading();
        this.setData({
          userInfo: {
            avatarUrl: res.data.userInfo.avatarUrl,
            nickName: res.data.userInfo.nickName
          },
          bType: 'warn',
          actionText: '退出登录',
          lock: true
        })
      }
    });
  },

//生命周期函数--监听页面显示
  onShow: function () {
    var that = this;
    if (!wx.getStorageSync('token')) {
      this.data.lock = false;
      this.setData({
        userInfo: {
          avatarUrl: "",
          nickName: "未登录"
        },
        bType: "primary",
        actionText: "登录"
      })
    }
  if(wx.getStorageSync('token')) {
    var params = {
      url:'token/verify',
      method:'post',
      sCallBack:(res)=>{
        if (res.statusCode == '401') {
          that.setData({
            userInfo: {
              avatarUrl: "",
              nickName: "未登录"
            },
            bType: "primary",
            actionText: "登录"
          });
        }
      }
    }
    }
  },


// 登录或退出登录按钮点击事件
  bindAction: function(){
    // 如果没有登录，登录按钮操作
    this.data.lock = !this.data.lock;
    if(this.data.lock){
      wx.showLoading({
        title: "正在登录"
      });
      var that = this;
      wx.login({
        success: (res) => {
          var params = {
            url:'token/user',
            method:'post',
            data:{
              code:res.code
            },
            sCallBack:(rel)=>{
              wx.setStorageSync('login', true);
              console.log(rel.data.token);
              wx.setStorageSync('token', rel.data.token);
              //把余额和保证金存储到缓存中
              var that = this;
              var params = {
                url:'user/wallet',
                method:'post',
                sCallBack:(res)=>{
                  wx.setStorageSync('balance', res.data.balance);
                  wx.setStorageSync('guarantee', res.data.guarantee);
                }
              };
              base.request(params);
            }
          };
          base.request(params);

          wx.hideLoading();
          wx.getUserInfo({
            withCredentials: false,
            success: (res) => {
              console.log(res);
              this.setData({
                userInfo: {
                  avatarUrl: res.userInfo.avatarUrl,
                  nickName: res.userInfo.nickName
                },
                bType: "warn",
                actionText: "退出登录"
              });
              wx.setStorageSync('userInfo', res);
            }     
          })
        }
      })
    // 如果已经登录，退出登录按钮操作     
    }else{
      wx.showModal({
        title: "确认退出?",
        content: "退出后将不能使用ofo",
        success: (res) => {
          if(res.confirm){
            console.log("确定")
            // 退出登录则移除本地用户信息
            wx.removeStorageSync('userInfo');
            wx.removeStorageSync('token');
            this.setData({
              userInfo: {
                avatarUrl: "",
                nickName: "未登录"
              },
              bType: "primary",
              actionText: "登录"
            })
          }else {
            console.log("cancel")
            this.setData({
              lock: true
            })
          }
        }
      })
    }   
  },
// 跳转至钱包
  movetoWallet: function(){
          wx.navigateTo({
            url: '../wallet/index',
          });
        }   
})