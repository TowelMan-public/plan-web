<?php

namespace App\Http\Requests;

use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{

    public DateTime $startDate;
    public DateTime $finishData;

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
            'todoName' => 'required|max:100',
            'startDateTimeYear' => 'integer|between:1980, 2200',
            'startDateTimeMonth' => 'integer|between:1, 12',
            'startDateTimeDay' => 'integer|between:1, 31',
            'startDateTimeHour' => 'integer|between:0, 23',
            'startDateTimeMinute' => 'integer|between:0, 59',
            'finishDateTimeYear' => 'integer|between:1980, 2200',
            'finishDateTimeMonth' => 'integer|between:1, 12',
            'finishDateTimeDay' => 'integer|between:1, 31',
            'finishDateTimeHour' => 'integer|between:0, 23',
            'finishDateTimeMinute' => 'integer|between:0, 59',
            'dateTimeError' => 'nullable',
        ];
    }

    
    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $this->startDate = DateUtility::createDate(
                $this->all()['startDateTimeYear']??2000,
                $this->all()['startDateTimeMonth']??1,
                $this->all()['startDateTimeDay']??1,
                $this->all()['startDateTimeHour']??1,
                $this->all()['startDateTimeMinute']??1
            );

            $this->finishData = DateUtility::createDate(
                $this->all()['finishDateTimeYear']??2001,
                $this->all()['finishDateTimeMonth']??1,
                $this->all()['finishDateTimeDay']??1,
                $this->all()['finishDateTimeHour']??1,
                $this->all()['finishDateTimeMinute']??1
            );

            if($this->startDate->getTimestamp() >= $this->finishData->getTimestamp()){
                $validator->errors()->add('dateTimeError', '日付の関係が不正です。');
            }
        });
        
    }
}