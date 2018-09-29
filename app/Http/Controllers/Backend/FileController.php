<?php
/**
 * Created by PhpStorm.
 * User: MrCong <i@cong5.net>
 * Date: 2017/2/12
 * Time: 16:28
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Persimmon\Storage\QiniuUploads;

class FileController extends Controller
{
    
    public function index(Request $request)
    {
        $files = $request->file('file')->store('local');

        return response()->json($files);
    }

    public function store(Request $request)
    {
        $files = $request->file('file')->store('local');

        $files = '/'.$files;

        return ['status' => 200, 'filename' => $files, 'url' => $files];
    }


}