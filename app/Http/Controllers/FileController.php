<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFileRequest;
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
    public function import(ImportFileRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $xml = $this->fileService->read($file->getContent());
        $data = $this->fileService->parse($xml);

        return response()->json($data);
    }
}
