<?php
/**
 * Created by PhpStorm.
 * User: MrCong <i@cong5.net>
 * Date: 2017/2/10
 * Time: 9:49
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Models\Categorys;
use Persimmon\Interfaces\CreatorInterface;

class CategorysController extends Controller implements CreatorInterface
{

    private $_response = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = intval($request->rows) > 0 ? $request->rows : 20;
        $listData = Categorys::paginate($rows);
        return response()->json($listData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'required',
            'category_flag' => 'required|flag'
        ]);
        app(\Persimmon\Creator\CategorysCreator::class)->create($this, $request);
        return response()->json($this->_response);
    }

    /**
     * Update a category
     * @param Request $request
     * @param $id
     */
    public function update(Request $request)
    {
        app(\Persimmon\Creator\CategorysCreator::class)->update($this, $request);
        return response()->json($this->_response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Categorys::find($id);
        return response()->json($data);
    }


    /**
     * Remove the specified  from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (empty($request->ids)) {
            return response()->json(['status' => 'error', 'info' => 'ID不能为空']);
        }
        $result = Categorys::whereIn('id',$request->ids)->delete();
        return response()->json(['status' => !$result ? 'error' : 'success']);
    }

    /**
     * Create Fail Use
     * @param $error
     * @return \Illuminate\Http\JsonResponse
     */
    public function creatorFail($error)
    {
        $this->_response = ['status' => 'error', 'info' => $error];
    }

    /**
     * Create Success Use
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function creatorSuccess($model)
    {
        $this->_response = ['status' => 'success', 'info' => '操作成功'];
    }

}