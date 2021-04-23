<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateClientRequest extends FormRequest
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
  public function rules(Request $request)
  {
    if($this->get('password') != ""){
      return [
        'name' => 'required|unique:client,name,'.$request->id
      ];
    }else{
      return [
        'name' => 'required|unique:client,name,'.$request->id
      ];
    }

  }
}
