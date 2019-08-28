//app.js
var qcloud = require('./vendor/wafer2-client-sdk/index')
var config = require('./config')

App({
    onLaunch: function () {
        qcloud.setLoginUrl(config.service.loginUrl)
    }, 
    getUserInfo: function (cb) {
    var that = this
    if (this.globalData.userInfo) {
      console.log("aaaaa")
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
      console.log("bbbb")
      //调用登录接口
      wx.login({
        success: function (loginres) {
          console.log("登录凭证：" + loginres.code)
          //appid:wx76aec7d8d5f5083f
          //secret:de369b1d7fcb9d07cecb30a7ea30fbf1
          //grant_type:authorization_code

          wx.getUserInfo({
            success: function (res) {
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
        }
      })
    }
  },
  globalData: {
    userInfo: null
  },
})