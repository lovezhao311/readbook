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
            // 用户信息
            wx.getUserInfo({
              withCredentials:true,
              success: function (res) {
                // 登录态维护
                myrequest.request({
                  url: 'http://readbook.com/api/onLogin',
                  data: {
                    "encryptedData": res.encryptedData
                  },
                  success: function (res) {                    
                  }
                })
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