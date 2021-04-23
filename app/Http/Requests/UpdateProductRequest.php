<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
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
      return [
          'manproduct_category_id' => 'required',
          'manproduct_type_id' => 'required',
          'manproduct_name' => 'required',
          'manproduct_code' => 'required',
          'manproduct_price_denom' => 'required',
          'manproduct_active' => 'required'
      ];
  }
}
