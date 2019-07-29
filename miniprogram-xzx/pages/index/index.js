//获取应用实例
Page({
  data: {
    product1:'',
    product2: '',
    product3: '',
    hidden: false
  },
  toProduct1: function () {
    console.log('product1');
    this.updateBtnStatus('product1');
  },
  toProduct2: function () {
    console.log('product2');
    this.updateBtnStatus('product2');
  },
  toProduct3: function () {
    console.log('product3');
    this.updateBtnStatus('product3');
  },
  onLaunch: function () {
    console.log('index Launching ...');
  },
  onShow: function () {
    var that = this;
    setTimeout(function () {
      that.setData({
        hidden: true
      });
    }, 1500);
  },
  updateBtnStatus: function (k) {
    this.setData({
      product1: this.getHoverd('product1', k),
      product2: this.getHoverd('product2', k),
      product3: this.getHoverd('product3', k),
    });
  },
  getHoverd: function (src, dest) {
    return (src === dest ? 'top-hoverd-btn' : '');
  },
  //通过绑定手机号登录
  getPhoneNumber: function (e) {
  var ivObj = e.detail.iv
  var telObj = e.detail.encryptedData
  var codeObj = "";
  var that = this;
  //------执行Login
  wx.login({
    success: res => {
      console.log('code转换', res.code); //用code传给服务器调换session_key

      wx.request({
        url: 'https://x.xxxxxxx.com/xiaochengxu/demo.php', //接口地址
        data: {
          appid: "小程序appid",
          secret: "小程序密钥",
          code: res.code,
          encryptedData: telObj,
          iv: ivObj
        },
        header: {
          'content-type': 'application/json' // 默认值
        },
        success: function (res) {
          phoneObj = res.data.phoneNumber;
          console.log("手机号=", phoneObj)
          wx.setStorage({   //存储数据并准备发送给下一页使用
            key: "phoneObj",
            data: res.data.phoneNumber,
          })
        }
      })

      //-----------------是否授权决定是否可以做题
      if (e.detail.errMsg == 'getPhoneNumber:fail user deny') { //用户点击拒绝判断
        wx.navigateTo({
          url: '../index/index',
        })
      } else { //授权通过执行跳转

        wx.navigateTo({
          url: '../questionnaire/questionnaire',
        })
      }
    }
  });

  //---------登录有效期检查
  wx.checkSession({
    success: function () {
      //session_key 未过期，并且在本生命周期一直有效
    },
    fail: function () {
      // session_key 已经失效，需要重新执行登录流程
      wx.login() //重新登录
    }
  });
  }, 

});
