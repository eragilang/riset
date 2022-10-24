<?php

namespace App\Http\Requests;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;
use Spatie\Permission\Models\Role;

class StoreHewanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $genre = Genre::all()->pluck('id');
        return [
            'nama' => 'required',
            'keterangan' => 'required',
            'objek' => 'required',
            'id_genre' => ['required', ValidationRule::in($genre)],
            'status' => 'nullable',
            'vr'=>'nullable',
            // 'username' => 'required|unique:users,username',
        ];
    }
}
