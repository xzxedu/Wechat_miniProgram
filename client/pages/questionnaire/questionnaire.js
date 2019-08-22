// pages/search/search.js

const requestUrl = require('../../config').requestUrl

Page({
  data: {
    key: '',
    winWidth: 0,
    winHeight: 0,
    // tab切换 
    currentTab: 0,
    phone: '',
    money: '',
    age: '',
    work_year: '',
    loan:'',
    project: '',
    ifLoan: [
      { "ID": 1, "Name": "是" },
      { "ID": 2, "Name": "否" }
    ],
    loanIndex: 0,
    saveMoney: '',
    rate: '',
    years: ''
  },

  onLoad: function () {
    var that = this

    //调用应用实例的方法获取全局数据
    var app = getApp()
    app.getUserInfo(function (userInfo) {
      //更新数据
      that.setData({
        userInfo: userInfo
      })
    });
    var that = this;
    wx.getSystemInfo({

      success: function (res) {
        that.setData({
          winWidth: res.windowWidth,
          winHeight: res.windowHeight
        });
      }
    });
  },

  bindChange: function (e) {
    var that = this;
    that.setData({ currentTab: e.detail.current });
  },

  swichNav: function (e) {
    var that = this;
    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },
  phoneInput: function (e) {
    this.setData({
      phone: e.detail.value
    })
  },
  ageInput: function (e) {
    this.setData({
      age: e.detail.value
    })
  },
  work_yearInput: function (e) {
    this.setData({
      work_year: e.detail.value
    })
  },
  salaryInput: function (e) {
    this.setData({
      money: e.detail.value
    })
  },


  //缴纳项目选择
  bindLoanChange: function (e) {
    this.setData({
      loanIndex: e.detail.value
    })
  },
  //存款金额
  loanInput: function (e) {
    this.setData({
      loan: e.detail.value
    })
  },
  //计算
  submitBtn: function (e) {
    if (this.data.currentTab == 0) {
      var output = 1;
      if (this.data.money == "") {
        output = 0;
        wx.showToast({
          title: '收入不能为空, 可填0',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      if (this.data.work_year == "") {
        output = 0;
        wx.showToast({
          title: '工龄不能为空，可填0',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      if (this.data.age == "") {
        output = 0;
        wx.showToast({
          title: '年龄不能为空',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      if (this.data.money == "") {
        output = 0;
        wx.showToast({
          title: '收入不能为空，可为0',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      if (output > 0) {
        wx.showToast({
          title: '感谢您的配合',
          icon: 'success',
          mask: true,
          duration: 1000
        })
      }
    } if (this.data.currentTab == 1) {
      var saveMoney = this.data.saveMoney;
      var rate = this.data.rate
      var years = this.data.years;
      saveMoney = parseFloat(saveMoney);
      rate = parseFloat(rate);
      years = parseFloat(years);
      var interest = 0;
      var i;
      for (i = 1; i <= years; i++) {
        interest += saveMoney * (rate / 100.0);
      }
      var all = (saveMoney + interest).toFixed(2);
      wx.showModal({
        title: '感谢您的配合！',
        //content: '本息一共' + all + '元',
        success: function (res) {
          if (res.confirm) {
            // console.log('用户点击确定')
          }
        }
      })

    }
  }
})