<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserConfigRequest extends FormRequest
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
            'beforeDeadlineForProjectNoticeDay'=>'integer|between:1,50',
            'beforeDeadlineForProjectNoticeHour'=>'integer|between:0,23',
            'beforeDeadlineForProjectNoticeMinute'=>'integer|between:0,59',
            'beforeDeadlineForTodoNoticeDay'=>'integer|between:1,50',
            'beforeDeadlineForTodoNoticeHour'=>'integer|between:0,23',
            'beforeDeadlineForTodoNoticeMinute'=>'integer|between:0,59',
        ];
    }
}