<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\Questions\QuestionGroupWithoutQuestionerResource;
use App\Models\BaseModel;
use App\Models\Blog\Blog;
use App\Models\Questions\Questioner;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            BaseModel::COLUMN_ID => $this->{BaseModel::COLUMN_ID},
            Blog::COLUMN_TITLE => $this->{Blog::COLUMN_TITLE},
            Blog::COLUMN_SLUG => $this->{Blog::COLUMN_SLUG},
            Blog::COLUMN_IMAGE_PATH => asset('storage/' . $this->{Blog::COLUMN_IMAGE_PATH}),
            Blog::COLUMN_BODY => $this->{Blog::COLUMN_BODY},
        ];
    }
}
