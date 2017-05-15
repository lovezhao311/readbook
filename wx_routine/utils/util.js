function formatTime(date) {
  var year = date.getFullYear()
  var month = date.getMonth() + 1
  var day = date.getDate()

  var hour = date.getHours()
  var minute = date.getMinutes()
  var second = date.getSeconds()


  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

function formatNumber(n) {
  n = n.toString()
  return n[1] ? n : '0' + n
}

module.exports = {
  formatTime: formatTime
}

var myrequest = {
  /**
   * option:{
   *  url: "",
   *  method: "",
   *  success: function(res){
   *  }
   * }
   */
  request: function (option){
    var defaultOption = {
      "url":option.url,
      "method": option.method,
      "dataType" : "json",
      "header": {
        "content-type": "application/json"
      },
      // 网络请求错误
      "fail" : function(){
        
      },
      // 网络请求完成
      "complete": function(){
      
      },
      // 网络请求成功
      "success":function(res){
        // 验证
        myrequest.resule(res);
        // 处理
        option.success(res);
      }
    };

    wx.request();
  },
  // 网络请求返回数据验证
  resule:function(res){
    // 操作失败
    if(res.code == 0){

    }
  }
}