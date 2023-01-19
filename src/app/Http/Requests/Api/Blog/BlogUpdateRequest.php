<?php

namespace App\Http\Requests\Api\Blog;

use App\Models\Blog\Blog;
use Illuminate\Validation\Rule;
use App\Http\Requests\Api\BaseRequest;

class BlogUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->authorizeUserRole('admin');
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Blog::COLUMN_TITLE => ['max:250'],
            'image' => [
                'nullable',
                'image',
                'mimes:' . implode(',', Blog::IMAGE_MIME_TYPES),
                'max:' . Blog::IMAGE_FILE_MAX_SIZE
            ],
            Blog::COLUMN_SLUG => [
                'max:250',
                Rule::unique(Blog::getDBTable())
                    ->whereNot(Blog::COLUMN_ID, $this->route('blog')->id)
                    ->whereNull(Blog::COLUMN_DELETED_AT)
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            Blog::COLUMN_TITLE . '.max' => __("blog/blog.validations.titleIsTooLong"),
            'image.image' => __("blog/blog.validations.fileShouldBeImage"),
            'image.mimes' => __(
                "blog/blog.validations.imageMimeNotCorrect",
                ['mime_types' => implode(',', Blog::IMAGE_MIME_TYPES)]
            ),
            'image.max' => __("blog/blog.validations.imageFileIsTooBig", ['size' => Blog::IMAGE_FILE_MAX_SIZE]),
            Blog::COLUMN_SLUG . '.max' => __("blog/blog.validations.slugIsTooLong"),
            Blog::COLUMN_SLUG . '.unique' => __("blog/blog.validations.slugIsTaken"),
        ];
    }


}
