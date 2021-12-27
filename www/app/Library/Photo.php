<?php

declare(strict_types=1);

namespace App\Library;

/**
 * Photo class.
 *
 * Date: 26.12.21
 * Time: 21:54
 *
 * @author Ruslan Bondar
 * @version 1.0
 * @package App\Library
 */
class Photo
{
    /**
     * Преобразовывает MIME base64 в jpg данные
     */
    public function bCodeToJpgData(string $bCode): string
    {
        $pngImage = $this->decode($bCode);
        $jpgImage = $this->toJpg($pngImage);
        return $jpgImage;
    }

    private function toJpg(string $image): string
    {
        $gdImage = imagecreatefromstring($image);
        $bg = imagecreatetruecolor(imagesx($gdImage), imagesy($gdImage));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, true);
        imagecopy($bg, $gdImage, 0, 0, 0, 0, imagesx($gdImage), imagesy($gdImage));
        imagedestroy($gdImage);
        ob_start();
        imagejpeg($bg);
        $result = ob_get_clean();
        imagedestroy($bg);

        return $result;
    }

    /**
     * Декодирует данные, закодированные MIME base64
     */
    private function decode(string $bCode): string
    {
        [$type, $data] = explode(';', $bCode);
        [, $data] = explode(',', $data);
        return base64_decode($data);
    }
}