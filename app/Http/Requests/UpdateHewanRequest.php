<?php

namespace App\Http\Requests;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UpdateHewanRequest extends FormRequest
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
        // Let's get the route param by name to get the User object value
        $genre = Genre::all()->pluck('id');
        return [
            'nama' => 'required',
            'keterangan' => 'required',
            'objek' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_genre' => ['required', Rule::in($genre)],
            'editor' => 'nullable',
            'status' => 'nullable',
            'vr'=>'nullable',
        ];
    }
}
