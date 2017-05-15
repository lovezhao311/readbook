<?php
use think\Route;

// blog子域名绑定到blog模块
Route::domain('www', 'index');
// 完整域名绑定到admin模块
Route::domain('admin', 'admin');
// IP绑定到admin模块
Route::domain('api', 'api');
