<?php

namespace App\Services;

use App\Models\File;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Throwable;

class FileService
{
    /**
     * Cast xml content to flat array
     *
     * @throws Exception
     */
    public function read(string $content): array
    {
        $parser = simplexml_load_string(
            $content,
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );

        $data = json_decode(json_encode($parser), true);
        $flat = Arr::dot($data);

        $paths = [];
        foreach ($flat as $key => $value) {
            if ($value) {
                $key = str_replace('.', '/', $key);
                $paths[] = ['path' => $key, 'value' => $value];
            }
        }

        return $paths;
    }
}
