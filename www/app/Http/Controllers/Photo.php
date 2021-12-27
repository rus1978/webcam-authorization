<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Library\Photo as PhotoLibrary;

class Photo extends Controller
{
    /**
     * Авторизация по фото
     *
     * @param  PhotoLibrary  $photo
     * @return string[]
     */
    public function auth(PhotoLibrary $photo): array
    {
        $faceData = $this->requestValidate();
        $jpgData = $photo->bCodeToJpgData($faceData);

        //build temp file
        $tmpFile = tmpfile();
        fwrite($tmpFile, $jpgData);
        $comparedImageName = stream_get_meta_data($tmpFile)['uri'];

        //compare face result
        $originImageName = Session::getId().'.jpg';
        exec('python3 ../app/dlib/euclidean.py '.$originImageName.' '.$comparedImageName, $output);
        $result = @json_decode($output[0], true);

        fclose($tmpFile);

        if (!$result) {
            return [
                'status'  => 'error',
                'message' => 'Произошла ошибка',
            ];
        }

        return $result;
    }

    /**
     * Сохранаить изображение в личном кабинете
     *
     * @param  PhotoLibrary  $photo
     *
     * @return string[]
     */
    public function save(PhotoLibrary $photo): array
    {
        $faceData = $this->requestValidate();

        $jpgData = $photo->bCodeToJpgData($faceData);

        $imageName = Session::getId().'.jpg';
        $isSave = Storage::put('/auth/users/'.$imageName, $jpgData);

        if ($isSave === true) {
            $response = [
                'status'  => 'success',
                'message' => 'Сохранено изображение ['.$imageName.']. '
                    .'Теперь его можно использовать для авторизации на главной странице',
            ];
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Не удалось сохранить изображение ['.$imageName.']',
            ];
        }

        return $response;
    }

    /**
     * Проверить и получить данные изображения face из запроса
     */
    private function requestValidate(): string
    {
        Request::validate(
            [
                'face' => 'required|min:255',
            ]
        );

        return Request::input('face');
    }
}
