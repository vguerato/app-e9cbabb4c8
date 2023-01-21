<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @throws Exception
     */
    public function import(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $content = $this->fileService->read($file->getContent());

        return response()->json($content);
    }
}
