<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TestController extends Controller
{
    private const HEADER_KEY_CONTENT_TYPE = 'Content-Type';
    private const HEADER_KEY_CONTENT_DISPOSITION = 'Content-Disposition';
    private const HEADER_VALUE_MIME_TYPE_PDF = 'application/pdf';
    private const HEADER_VALUE_CHARSET_UTF_8 = 'charset=utf-8';

    public function test()
    {
        $pdfInStorage = storage_path('app/tests/book.pdf');

        $total = $this->getTotal($pdfInStorage);
        $content = '';

        for ($i = 1; $i <= $total; $i++) {
            $data = $this->getPaginatedContent($pdfInStorage, $i)['data'] ?? '';
            $content .= $data ? base64_decode($data) : '';
        }

        return $this->getStreamedResponse('hello.pdf', $content);
    }

    public function testWithPacking()
    {
        $fileName = 'hello.pdf';

        $pdfInStorage = storage_path('app/tests/test.pdf');
        $content = file_get_contents($pdfInStorage);

        $bin = unpack('H*', $content);
        $base = base64_encode($content);

        $jsonBin = json_encode([
            'value' => $bin[1],
        ]);
        $jsonBase = json_encode([
            'value' => $base,
        ]);

        $decodedBin = pack(
            'H*',
            json_decode($jsonBin, true)['value']
        );
        $decodedBase = base64_decode(
            json_decode($jsonBase, true)['value']
        );

//        $content = $decodedBin;
        $content = $decodedBase;

        return $this->getStreamedResponse($fileName, $content);
    }

    protected function getTotal(string $fileInStorage): int
    {
        $bufferSize = 1024 * 1024; // 1 megabyte

        return (int)ceil(filesize($fileInStorage) / $bufferSize);
    }

    protected function getPaginatedContent(string $fileInStorage, int $page = 1): array
    {
        $page = $page <= 0 ? 1 : $page;
        $bufferSize = 1024 * 1024; // 1 megabyte
        $handle = fopen($fileInStorage, 'r');
        $fseekResult = fseek($handle, $bufferSize * ($page - 1));
        $data = '';
        $total = $this->getTotal($fileInStorage);

        if ($fseekResult === -1) {
            return compact('page', 'data', 'total');
        }
        $data = base64_encode(fread($handle, $bufferSize));

        return compact('page', 'data', 'total');
    }

    public function testPdf(Request $request)
    {
        $fileName = 'hello.pdf';

        $streamedResponse = new StreamedResponse();
        $streamedResponse->setCallback(function () {
            $bufferSize = 1024;
            $tmpHandle = fopen(storage_path('app/tests/test.pdf'), 'r');
            $handle = fopen('php://output', 'w');

            while (! feof($tmpHandle)) {
                $data = fread($tmpHandle, $bufferSize);
                dump($data);
                fwrite($handle, $data);
            }

            fclose($tmpHandle);
            fclose($handle);
        });
        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set(static::HEADER_KEY_CONTENT_TYPE, sprintf('%s; %s', static::HEADER_VALUE_MIME_TYPE_PDF, static::HEADER_VALUE_CHARSET_UTF_8));
        $streamedResponse->headers->set(static::HEADER_KEY_CONTENT_DISPOSITION, sprintf('attachment; filename="%s"', $fileName));

        return $streamedResponse;
    }

    protected function getStreamedResponse(string $fileName, string $content = null)
    {
        $streamedResponse = new StreamedResponse();
        $streamedResponse->setCallback(function () use ($content) {
            file_put_contents('php://output', $content);
        });

        $streamedResponse->setStatusCode(Response::HTTP_OK);
        $streamedResponse->headers->set(static::HEADER_KEY_CONTENT_TYPE, sprintf('%s; %s', static::HEADER_VALUE_MIME_TYPE_PDF, static::HEADER_VALUE_CHARSET_UTF_8));
        $streamedResponse->headers->set(static::HEADER_KEY_CONTENT_DISPOSITION, sprintf('attachment; filename="%s"', $fileName));

        return $streamedResponse;
    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }

    public function testResetPasswordMarkup()
    {
        return new TestMarkupResetPasswordMail();
    }
}
