<?php

namespace App\Http\Requests;

use App\Enums\ActionType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read int $type_id
 * @property-read int $user_id
 * @property-read string $date_from
 * @property-read string $date_to
 */
class ActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type_id' => ['required', Rule::enum(ActionType::class)],
            'user_id' => ['required', 'exists:users,id'],
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date', 'after:date_from'],
        ];
    }

    public function getActionType(): ActionType
    {
        return ActionType::from($this->type_id);
    }

    public function getDateFrom(): Carbon
    {
        return Carbon::parse($this->date_from);
    }

    public function getDateTo(): Carbon
    {
        return Carbon::parse($this->date_to);
    }
}
