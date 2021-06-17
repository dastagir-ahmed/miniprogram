<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class CommonController extends BaseController
{

    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"公共接口"},
     *     path="/api/common/upload",
     *     summary="上传文件图片头像等，使用md5值作为文件名 防止重复文件",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               @OA\Property(
     *                  property="file",
     *                  type="file",
     *                  format="file"
     *               ),
     *           ),
     *       )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function upload(Request $request)
    {
        $file=$request->file('file');
        $path = $file->storeAs('file',md5_file($file)
            .'.'.strtolower($file->getClientOriginalExtension()));
        return response()->json([
            "code" => 0
            , "data" => $path
            , "msg" => "成功"
        ]);
    }
}
