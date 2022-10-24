<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;
use Spatie\Permission\Models\Role;

class StoreUserRequest extends FormRequest
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
        $roles = Role::all()->pluck('name');
        return [
            'name' => 'required',
            'alamat' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'role' => ['required', ValidationRule::in($roles)],
            'status' => 'nullable',
            // 'username' => 'required|unique:users,username',
        ];
    }
}
