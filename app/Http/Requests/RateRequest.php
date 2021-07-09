<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
        return [
            "hotel_id"      =>"required",
            "from_date"     =>"required|date",
            "to_date"     =>"required|date",
            "rate_for_adult"     =>"required|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",
            "rate_for_child"     =>"required|max:99999999.99|regex:/^\d+(\.\d{1,2})?$/",

        ];
    }
    public function messages()
    {
        return [
            "hotel_id.required"      =>"Please Select Hotel",
            "from_date.required"     =>"Please Select From Date",
            "from_date.date"     =>"Please Valid Select From Date",
            "to_date.required"     =>"Please Select To Date",
            "to_date.date"     =>"Please Valid Select To Date",
            "rate_for_adult.required"     =>"Please Enter Rate for Adult",
            "rate_for_adult.max"     =>"Please Enter Valid Rate",
            "rate_for_adult.regex"     =>"Please Enter Valid Rate",
            "rate_for_child.required"     =>"Please Enter Rate for Child",
            "rate_for_child.max"     =>"Please Enter Valid Rate",
            "rate_for_child.regex"     =>"Please Enter Valid Rate",
        ];
    }
}
