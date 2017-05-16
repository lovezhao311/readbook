var message = require('message.js')

var myrequest = {
  /**
   * 网络请求
   */
  request: function (option) {
    var defaultOption = {
      "url": option.url,
      "method": option.method,
      "data": option.data,
      "dataType": "json",
      "header": {
        "content-type": "application/json"
      },
      // 网络请求错误
      "fail": function () {
        wx.hideLoading()
        message.error('网络错误');
      },
      // 网络请求完成
      "complete": function () {
        
      },
      // 网络请求成功
      "success": function (res) {
        wx.hideLoading()
        // 验证
        var resule = myrequest.resule(res);
        if (resule === false) {
          return false;
        }
        // 处理
        option.success(res.data);
      }
    };
    message.loding();
    wx.request(defaultOption);
  },
  /**
   * 网络请求返回数据验证
   */
  resule: function (res) {
    // 返回类型不正确，不是有效的json
    if (typeof (res) !== 'object') {
      message.error('网络错误');
      return false;
    }
    return true;
  },
  /**
   * 登录
   */
  login: function () {
    //登录态过期
    wx.login({
      success: function (res) {
        // 用户信息
        wx.getUserInfo({
          withCredentials: true,
          success: function (user) {
            // 登录
            myrequest.request({
              url: 'http://api.luffybook.com/login',
              data: {
                "encryptedData": user,
                "code": res.code
              },
              method:"POST",
              success: function (res) {
                // 有用户信息
                if(res.code == 1){
                  wx.setStorageSync('userInfo', res)
                }else{
                }
              }
            })
          }
        })
      }
    }) //重新登录
  }
}

exports.myrequest = myrequest;