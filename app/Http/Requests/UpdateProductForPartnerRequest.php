<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductForPartnerRequest extends FormRequest
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
          'partnerId' => 'required',
          'partnerProductName' => 'required',
          'partnerProductCode' => 'required',
          'price' => 'required',
          'denom' => 'required',
          'status' => 'required'
      ];
  }
}
