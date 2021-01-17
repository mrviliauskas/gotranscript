<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Class FilesController
 * @package App\Http\Controllers\Api
 */
class FilesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => ['required'],
            'valid_from' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return \response()->json([
                'message' => $validator->messages()->first(),
            ],422);
        }

        $url = $request->get('image_url');
        $contents = file_get_contents($url);
        $hashName = md5($url . Carbon::now()->timestamp);

        Storage::disk('users_uploads')->put($hashName, $contents);
        File::create([
            'path' => File::PATH_USER_UPLOADS . '/' . $hashName,
            'original_name' => $url,
            'valid_from' => $request->get('valid_from')
        ]);

        return \response()->json([
            'message' => 'success.',
        ],200);    }
}
