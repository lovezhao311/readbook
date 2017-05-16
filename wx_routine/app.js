//app.js
var request = require('/utils/request.js')
App({
  onLaunch: function () {
    
  },
  getUserInfo: function(){
    wx.checkSession({
      success: function () {
        try {
          var userInfo = wx.getStorageSync('userInfo')
          if (!userInfo) {
            request.myrequest.login();
          }
        } catch (e) {
          console.log(e);
        }
      },
      fail: function () {
        request.myrequest.login();
      }
    })
  }
})

