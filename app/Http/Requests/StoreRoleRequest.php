<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRoleRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
      return Auth::check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
      return [
          'email' => 'required|unique:users,email,'.$request->id,
          'name' => 'required',
          'status' => 'required',
          'username' => 'required',
          'id_product' => '',
          'id_client' => '',
          'role_id' => '',
          'author' => '',
          'password' => 'required|confirmed|min:6|max:10',
          'password_confirmation' => 'required|min:6|max:10'      
];
  }
}
