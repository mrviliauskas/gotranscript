<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class FilesController
 * @package App\Http\Controllers
 */
class FilesController extends Controller
{
    /**
     * @param ImageUploadRequest $request
     */
    public function store(ImageUploadRequest $request)
    {
        $image = $request->image;
        $fileOriginalName = $image->getClientOriginalName();
        $hashName = md5($fileOriginalName . Carbon::now()->timestamp);

        Storage::disk('users_uploads')->putFileAs('', $image, $hashName);
        File::create([
            'path' => File::PATH_USER_UPLOADS . '/' . $hashName,
            'original_name' => $fileOriginalName,
            'valid_from' => $request->get('valid_from')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request): Collection
    {
        $offset = ($request->get('page', 1) - 1) * File::ITEMS_PER_PAGE;

        return File::query()
            ->where('valid_from', '<=', Carbon::now())
            ->offset($offset)
            ->limit(File::ITEMS_PER_PAGE)
            ->get();
    }
}
