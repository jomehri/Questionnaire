<?php

namespace App\Services\Blog;

use App\Models\Blog\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionGroup;
use App\Http\Resources\Questions\QuestionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class BlogService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            Blog::COLUMN_TITLE => $request->post('title'),
            Blog::COLUMN_SLUG => $request->post('slug'),
            'image' => $request->file('image'),
            Blog::COLUMN_BODY => $request->post('body'),
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {
            /**
             * File Upload
             */
            $directoryPath = 'blog/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now()->day;
            $filePath = Storage::disk('local')->put($directoryPath, $data['image']);

            /**
             * DB create
             */
            $item = new Blog();
            $item->setTitle($data[Blog::COLUMN_TITLE])
                ->setSlug($data[Blog::COLUMN_SLUG])
                ->setImagePath($filePath)
                ->setBody($data[Blog::COLUMN_BODY])
                ->save();
        });
    }

    /**
     * @param QuestionGroup $questionGroup
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(QuestionGroup $questionGroup, int $page): AnonymousResourceCollection
    {
        $items = Question::forQuestionGroup($questionGroup->id)->forPage($page, $this->perPage)->get();

        return QuestionResource::collection($items);
    }

    /**
     * @param QuestionGroup $questionGroup
     * @return int
     */
    public function countTotal(QuestionGroup $questionGroup): int
    {
        return Question::forQuestionGroup($questionGroup->id)->count();
    }

}
