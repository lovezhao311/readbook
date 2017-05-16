//index.js
//获取应用实例
var app = getApp()
var request = require('../../utils/request.js')
Page({
  data: {
    bookList:{
    }
  },
  //事件处理函数
  bindViewTap: function() {

  },
  onLoad: function () {
    var that = this;
    // 获取登录用户信息
    app.getUserInfo();
    // 获取主页面数据
    request.myrequest.request({
      url: 'http://api.luffybook.com/index/books',
      method: "POST",
      success: function (res) {
        if(res.code == 1){
          that.setData({
            bookList: res.data
          });
        }
      }
    });
  }
})
