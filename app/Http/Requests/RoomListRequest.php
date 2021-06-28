<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseJsonFormRequest;

class RoomListRequest extends BaseJsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'order' => ['nullable', 'string', 'in:price,created_at'],
            'sort' => ['nullable', 'string', 'in:asc,desc']
        ];
    }

    public function getOrder()
    {
        return $this->get('order') ?: 'created_at';
    }

    public function getSort()
    {
        return $this->get('sort') ?: 'asc';
    }
}
