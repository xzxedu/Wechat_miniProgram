// pages/search/search.js

const requestUrl = require('../../config').requestUrl

var getTagData = function (that) {
  wx.request({
    url: requestUrl + 'wxTagListGet.ashx',
    success: function (res) {
      that.setData({
        tagList: res.data.ChinaValue
      })
    }
  })
}

var search = function (that) {
  if (that.data.key.length > 0) {
    wx.navigateTo({
      url: '../result/result?KeyWord=' + that.data.key
    })
  }
  else {
    wx.showToast({
      title: '输入关键字',
      image: "../../images/icon-no.png",
      mask: true,
      duration: 1000
    })
  }
}



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

  //事件处理函数
  formSearch: function () {
    search(this)
  },

  //点击标签
  bindTagTap: function (e) {
    wx.navigateTo({
      url: '../result/result?KeyWord=' + e.currentTarget.dataset.id
    })
  },

  //长按封面图 重新加载
  bindRefresh: function () {
    getTagData(this)
  },

  bindKeyInput: function (e) {
    this.setData({
      key: e.detail.value
    })
  },

  bindInputSearch: function () {
    search(this)
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

  onShow: function () {
    var that = this
    that.setData({
      key: ''
    })
    getTagData(that)
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
      var StartNum = 3500;
      if (this.data.money == "") {
        wx.showToast({
          title: '收入不能为空, 可填0',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      if (this.data.age == "") {
        wx.showToast({
          title: '年龄不能为空',
          image: "../../images/icon-no.png",
          mask: true,
          duration: 1000
        })
        return false
      }
      var Salary = this.data.money;
      var Salary = Salary - (Salary * 0.08 + Salary * 0.02 + 10 + Salary * 0.01 + Salary * 0.08);
      var cha = (Salary - StartNum);
      var output;
      if (cha > 100000) {
        output = cha * 0.45 - 15375;
      } else if (cha > 80000) {
        output = cha * 0.4 - 10375;
      } else if (cha > 60000) {
        output = cha * 0.35 - 6375;
      } else if (cha > 40000) {
        output = cha * 0.30 - 3375;
      } else if (cha > 20000) {
        output = cha * 0.25 - 1375;
      } else if (cha > 5000) {
        output = cha * 0.2 - 375;
      } else if (cha > 2000) {
        output = cha * 0.15 - 125;
      } else if (cha > 500) {
        output = cha * 0.1 - 25;
      } else if (cha > 0) {
        output = cha * 0.05;
      } else {
        output = 0;
      }
      var result = Salary - output;
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
        content: '本息一共' + all + '元',
        success: function (res) {
          if (res.confirm) {
            // console.log('用户点击确定')
          }
        }
      })

    }
  }
})