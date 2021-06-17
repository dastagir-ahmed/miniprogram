<?php

use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/activity/activity', 'ActivityController');
    $router->resource('/activity/activityrecord', 'ActivityRecordController');
    $router->resource('/article/article', 'ArticleController');
    $router->resource('/article/articlerecommend', 'ArticleRecommendController');
    $router->resource('/article/articlecomment', 'ArticleCommentController');
    $router->resource('/article/articlerecord', 'ArticleRecordController');
    $router->resource('/attendance/attendancerecord', 'AttendanceRecordController');
    $router->resource('/column/column', 'ColumnController');
    $router->resource('/feedback/feedback', 'FeedbackController');
    $router->resource('/feedbacktype/feedbacktype', 'FeedbackTypeController');
    $router->resource('/forum/forum', 'ForumController');
    $router->resource('/forumrecord/forumrecord', 'ForumRecordController');
    $router->resource('/forumcomment/forumcomment', 'ForumCommentController');
    $router->resource('/news/news', 'NewsController');
    $router->resource('/newsrecord/newsrecord', 'NewsRecordController');
    $router->resource('/quwenqiushi/quwenqiushi', 'QuwenQiushiController');
    $router->resource('/starplan/starplan', 'StarPlanController');
    $router->resource('/user/user', 'UserController');
});
//php artisan admin:make ArticleController --model=App\\Admin\\Models\\Article
