<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>['string','max:250','required'],
            'game_id'=>['required','exists:games,id'],
            'start_date'=>['string','required','after_or_equal:today'],
        ];
    }
}
