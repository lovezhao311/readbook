//app.js
App({
  onLaunch: function () {
    wx.checkSession({
      success: function () {
        //session 未过期，并且在本生命周期一直有效
      },
      fail: function () {
        //登录态过期
        wx.login({
          success: function (res) {
            // 登录态维护
            wx.request({
              url: 'http://readbook.com/api/onLogin',
              data: {
                "code": res.code
              },
              success: function (res) {
                
              }
            })
            // 用户信息
            wx.getUserInfo({
              success: function (res) {
                that.globalData.userInfo = res.userInfo
              }
            })
          }
        }) //重新登录
      }
    })
  },
  globalData:{
    userInfo:null
  }
})