// pages/wallet/index.js
const AV = require('../../utils/av-weapp-min.js'); 
Page({
  data:{
    // 故障车周围环境图路径数组
    picUrls: [],
    // 故障车编号和备注
    inputValue: {
      num: 0,
      desc: ""
    },
    // 故障类型数组
    checkboxValue: [],
    // 选取图片提示
    actionText: "拍照/相册",
    // 提交按钮的背景色，未勾选类型时无颜色
    btnBgc: "",
    // 复选框的value，此处预定义，然后循环渲染到页面
  },
// 页面加载
  onLoad:function(options){
    var that = this;
    wx.setNavigationBarTitle({
      title: '报障维修'
    });
    
    //获取故障的类型
    wx.request({
      url: 'https://30166482.qcloud.la/index.php/api/v1/trouble',
      method:'post',
      success:function(res) {
        let data = res.data.map((item, index, arr) => {
          return {
            "id": item.id,
            "value": item.name
          }
        })
        console.log(data);
        that.setData({
          itemsValue: data
        });
      }
    })
  },
// 勾选故障类型，获取类型值存入checkboxValue
  checkboxChange: function(e){
    let _values = e.detail.value;
    if(_values.length == 0){
      this.setData({
        btnBgc: ""
      })
    }else{
      this.setData({
        checkboxValue: _values,
        btnBgc: "#b9dd08"
      })
    }   
  },
// 输入单车编号，存入inputValue
  numberChange: function(e){
    this.setData({
      inputValue: {
        num: e.detail.value,
        desc: this.data.inputValue.desc
      }
    })
  },
// 输入备注，存入inputValue
  descChange: function(e){
    this.setData({
      inputValue: {
        num: this.data.inputValue.num,
        desc: e.detail.value
      }
    })
  },
// 提交到服务器
  formSubmit: function(e){
    //获取单车的位置
    this.setData({
      address: {
        'start_lati': wx.getStorageSync('start_lati'),
        'start_long': wx.getStorageSync('start_long')
      
    }});
    //设置需要提交的数据
    this.setData({
      record:{
        picUrls: this.data.picUrls,
        inputValue: this.data.inputValue,
        checkboxValue: this.data.checkboxValue,
        address:this.data.address
      }
    });

    console.log(this.data.record);
    if(this.data.checkboxValue.length> 0){
      wx.request({
        url: 'https://30166482.qcloud.la/index.php/api/v1/trouble/record',
        data: {
          record:this.data.record
        },
        method: 'post', // POST
        header:{
          'content-type':'application/json',
          'token':wx.getStorageSync('token')
        },
        success: function(res){
          console.log(res);
          if(res.statusCode == '401') {
            wx.showModal({
              title: '提交失败',
              content: res.data.msg,
              showCancel: false,
            });
          }else {
            wx.showModal({
              title: '提交成功',
              content: "谢谢您的反馈",
              showCancel: false,
              success: function (res) {
                wx.navigateBack({
                  delta:1
                })
              },
            });
          }
        }
      })
    }else{
      wx.showModal({
        title: '提交失败',
        content: '请选择故障的类型',
        showCancel:false,
      });
    }
    
  },
// 选择故障车周围环境图 拍照或选择相册
  bindCamera: function(){
    wx.chooseImage({
      count: 4, 
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'], 
      success: (res) => {
        let tfps = res.tempFilePaths;
        let _picUrls = this.data.picUrls;
        for(let item of tfps){
          _picUrls.push(item);
          this.setData({
            picUrls: _picUrls,
            actionText: "+"
          });
        };
        var tempFilePath = res.tempFilePaths[0];
        new AV.File('pictrue', {
          blob: {
            uri: tempFilePath,
          },
        }).save().then(
          file => console.log(file.url())
        ).catch(console.error);
      }
    })
  },
// 删除选择的故障车周围环境图
  delPic: function(e){
    let index = e.target.dataset.index;
    let _picUrls = this.data.picUrls;
    _picUrls.splice(index,1);
    this.setData({
      picUrls: _picUrls
    })
  }
})