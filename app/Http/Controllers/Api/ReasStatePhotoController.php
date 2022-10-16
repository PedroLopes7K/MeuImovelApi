<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RealStatePhoto;
use App\Api\ApiMessages;
use Illuminate\Support\Facades\Storage;

class ReasStatePhotoController extends Controller
{
    private $realStatePhoto;
    public function __construct(RealStatePhoto $realStatePhoto)
    {

        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId)
    {
        try {

            $photo = $this->realStatePhoto->where('real_state_id' . $realStateId)->where('is_thumb', true);

            if ($photo->count()) $photo->first()->update(['is_thumb' => false]);

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);


            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function remove($photoId)
    {

        try {
            $photo = $this->realStatePhoto->find($photoId);
            if ($photo) {
                // removendo o arquivo do disco
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }


            return response()->json([
                'data' => [
                    'msg' => 'Thumb deletada com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
