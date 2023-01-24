<?php

namespace App\Services;

use Error;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use SimpleXMLElement;
use Throwable;
use XMLReader;

class FileService
{
    /**
     * Open xml file
     *
     * @throws Exception
     */
    public function read(string $content): SimpleXMLElement
    {
        try {
            return simplexml_load_string($content);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Cast xml content to flat array
     *
     * @throws Exception
     */
    public function parse(SimpleXMLElement $xml): array
    {
        $data = json_decode(json_encode($xml), true);
        $flat = Arr::dot($data);

        $paths = [];
        foreach ($flat as $key => $value) {
            if ((strrpos($key, '@attributes') === false) && $value) {
                $key = str_replace('.', '/', $key);
                $paths[] = ['path' => $key, 'value' => $value];
            }
        }

        return $paths;
    }
}
