var loding = function(){
  wx.showLoading({
    "title": '加载中',
    "showToast": true
  })
}

var error = function(msg){
  wx.showToast({
    "title": msg,
    "image": '/images/error.png',
    "duration": 2000
  });
}


exports.error = error;
exports.loding = loding;