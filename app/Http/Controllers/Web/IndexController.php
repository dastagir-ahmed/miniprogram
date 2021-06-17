<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/3 0003
 * Time: 9:28
 */

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


class IndexController extends Controller
{

    public function index()
    {



        return redirect('/admin');
       // return view('welcome');

    }




}
