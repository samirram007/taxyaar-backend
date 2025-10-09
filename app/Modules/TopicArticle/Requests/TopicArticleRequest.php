<?php

namespace App\Modules\TopicArticle\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique("{$connection}.topic_articles")
                    ->where(fn($query) => $query->where('topic_section_id', $this->input('topic_section_id')))
                    ->ignore($this->route('topic_article')),
            ],
            'slug' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                Rule::unique("{$connection}.topic_articles")
                    ->where(fn($query) => $query->where('topic_section_id', $this->input('topic_section_id')))
                    ->ignore($this->route('topic_article')),
            ],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'nullable', 'string', 'max:255'],
            'is_marked' => ['sometimes', 'nullable', 'boolean'],
            'content' => ['sometimes', 'nullable', 'string'],
            'author_id' => ['sometimes', 'nullable', 'numeric'],
            'published_at' => ['sometimes', 'nullable', 'datetime'],

            'topic_section_id' => ['required', 'numeric', "exists:{$connection}.topic_sections,id"],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.unique' => 'The name has already been taken.',
            'code.required' => 'The code field is required.',
            'code.string' => 'The code must be a string.',
            'code.max' => 'The code may not be greater than 255 characters.',
            'code.unique' => 'The code has already been taken.',
            'description.required   ' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
        ];
    }
}
