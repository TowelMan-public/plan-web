<?php

namespace App\Http\Requests;

use App\Utility\DateUtility;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class InsertTodoOnProjectRequest extends FormRequest
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
            'contentArray' => 'nullable',
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

            $contentArray = $this->get('contentArray', []);

            foreach ($contentArray as $key => $content) {
                if($content['title'] === null ||
                    $content['title'] === '' || mb_strlen($content['title']) > 100)
                {
                    $validator->errors()->add("contentArray.".$key.".title", '内容のタイトルは必須です。100文字以内でご入力ください');
                    dd(453);
                }

                if($content['explanation'] === null ||
                    $content['explanation'] === '' || mb_strlen($content['explanation']) > 2000)
                {
                    $validator->errors()->add("contentArray.".$key.".explanation", '内容の説明は必須です。2000文字以内でご入力ください');
                    dd(453);
                }
            }
        });
        
    }
}