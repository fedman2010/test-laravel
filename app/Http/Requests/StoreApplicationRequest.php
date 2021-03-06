<?php

namespace App\Http\Requests;

use App\Models\Application;
use App\Rules\OnePerDayRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Application::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic' => 'required|max:255',
            'message' => 'required',
            'file' => 'required|file|max:100',
            'created_at' => [new OnePerDayRule(Application::class)],
        ];
    }
}
