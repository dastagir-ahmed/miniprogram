<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function(){
    //UserController
    Route::get('user/login','UserController@login');
    Route::get('user/phonelogin','UserController@phoneLogin');
    Route::post('user/register','UserController@register');
    Route::post('user/phoneregister','UserController@phoneRegister');
    Route::post('user/resetpwd1','UserController@resetPwd1');
    Route::post('user/resetpwd2','UserController@resetPwd2');
    Route::post('user/updatepwd','UserController@updatePwd')->middleware('UserCheck');
    Route::get('user/getinfo','UserController@getInfo')->middleware('UserCheck');
    Route::post('user/updateinfo','UserController@updateInfo')->middleware('UserCheck');
    Route::get('user/getstarlist','UserController@getStarList')->middleware('UserCheck');
    Route::get('user/getcoinlist','UserController@getCoinList')->middleware('UserCheck');
    //UserMessageController
    Route::get('usermessage/getlist','UserMessageController@getList')->middleware('UserCheck');
    //ColumnController
    Route::get('column/getlist','ColumnController@getList');
    //ArticleController
    Route::get('article/getdetail','ArticleController@getDetail');
    //QuwenQiushiController
    Route::get('quwenqiushi/getdetail','QuwenQiushiController@getDetail');
    Route::get('quwenqiushi/getlist','QuwenQiushiController@getList');
    //NewsController
    Route::get('news/getdetail','NewsController@getDetail');
    Route::get('news/getlist','NewsController@getList');
    //ArticleRecordController
    Route::post('articlerecord/save','ArticleRecordController@save');
    //GatewayController
    Route::post('gateway/bind','GatewayController@bind')->middleware('UserCheck');
    //QuwenQiushiRecordController
    Route::post('quwenqiushirecord/save','QuwenQiushiRecordController@save');
    //NewsRecordController
    Route::post('newsrecord/save','NewsRecordController@save');
    //ArticleCommentLikeController
    Route::post('articlecommentlike/save','ArticleCommentLikeController@save');
    //TutorMessageController
    Route::get('tutormessage/getlist','TutorMessageController@getList')->middleware('UserCheck');
    //ArticleCommentController
    Route::get('articlecomment/getlist','ArticleCommentController@getList');
    Route::get('articlecomment/delete','ArticleCommentController@delete')->middleware('UserCheck');
    Route::post('articlecomment/save','ArticleCommentController@save')->middleware('UserCheck');
    //TutorController
    Route::post('tutor/save','TutorController@save')->middleware('UserCheck');
    //TutorMyController
    Route::post('tutormy/save','TutorMyController@save')->middleware('UserCheck');
    //ForumController
    Route::get('forum/getdetail','ForumController@getDetail');
    Route::post('forum/save','ForumController@save')->middleware('UserCheck');
    Route::get('forum/getlist','ForumController@getList');
    //ForumRecordController
    Route::post('forumrecord/save','ForumRecordController@save');
    //ForumCommentController
    Route::get('forumcomment/getlist','ForumCommentController@getList');
    Route::get('forumcomment/delete','ForumCommentController@delete')->middleware('UserCheck');
    Route::post('forumcomment/save','ForumCommentController@save')->middleware('UserCheck');
    //ForumCommentLikeController
    Route::post('forumcommentlike/save','ForumCommentLikeController@save');
    //FeedbackController
    Route::post('feedback/save','FeedbackController@save')->middleware('UserCheck');
    //ZaoChenJiaYouRecordController
    Route::post('zaochenjiayourecord/save','ZaoChenJiaYouRecordController@save')->middleware('UserCheck');
    //FeedbackTypeController
    Route::get('feedbacktype/getlist','FeedbackTypeController@getList');
    //ActivityController
    Route::get('activity/getlist','ActivityController@getList');
    Route::get('activity/getdetail','ActivityController@getDetail');
    //ActivityRecordController
    Route::post('activityrecord/save','ActivityRecordController@save')->middleware('UserCheck');
    //QuestionController
    Route::get('question/getlist','QuestionController@getList')->middleware('UserCheck');
    //UserQuestionRecordController
    Route::post('userquestionrecord/save','UserQuestionRecordController@save')->middleware('UserCheck');
    //StarPlanController
    Route::get('starplan/getlist','StarPlanController@getList');
    //UserQuestionRecordController
    Route::post('starplanrecord/save','StarPlanRecordController@save')->middleware('UserCheck');
    //CommonController
    Route::post('common/upload','CommonController@upload')->middleware('UserCheck');
});
