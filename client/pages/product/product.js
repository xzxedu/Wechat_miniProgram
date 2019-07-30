//获取应用实例
Page({
  data: {
    new: 'top-hoverd-btn',
    insurance: '',
    stock: '',
    fund: '',
    foreign: '',
    bond: '',
    hidden: false
  },
  toNew: function () {
    console.log('new');
    this.updateBtnStatus('new');
  },
  toInsurance: function () {
    console.log('insurance');
    this.updateBtnStatus('insurance');
  },
  toStock: function () {
    console.log('stock');
    this.updateBtnStatus('stock');
  },
  toFund: function () {
    console.log('fund');
    this.updateBtnStatus('fund');
  },
  toForeign: function () {
    console.log('foreign');
    this.updateBtnStatus('foreign');
  },
  toBond: function () {
    console.log('bond');
    this.updateBtnStatus('bond');
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
      new: this.getHoverd('new', k),
      insurance: this.getHoverd('insurance', k),
      stock: this.getHoverd('stock', k),
      fund: this.getHoverd('fund', k),
      foreign: this.getHoverd('foreign', k),
      bond: this.getHoverd('bond', k)
    });
  },
  getHoverd: function (src, dest) {
    return (src === dest ? 'top-hoverd-btn' : '');
  }
});
