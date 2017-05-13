<?php
use think\Route;
// 注册路由到index模块的News控制器的read操作
Route::rule('b/:id$', 'index/book/index');

Route::rule('b/:bid/:id$', 'index/book/chapter');
