<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\QuestionGroup;
use App\Http\Resources\Questions\QuestionGroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestionGroupService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            QuestionGroup::COLUMN_TITLE => $request->post('title'),
            'questioner_ids' => $request->post('questioner_ids'),
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
             * 1- Add new question group
             */
            $item = new QuestionGroup();
            $item->setTitle($data[QuestionGroup::COLUMN_TITLE])
                ->save();

            /**
             * 2- Also add them to questioners
             */
            $this->syncQuestionerPivot($item);
        });
    }

    /**
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(int $page): AnonymousResourceCollection
    {
        $items = QuestionGroup::with('questioners')->forPage($page, $this->perPage)->get();

        return QuestionGroupResource::collection($items);
    }

    /**
     * @return int
     */
    public function countTotal(): int
    {
        return QuestionGroup::all()->count();
    }

    /**
     * @param QuestionGroup $item
     * @return void
     */
    private function syncQuestionerPivot(QuestionGroup $item): void
    {
        if (empty($data['questioner_ids'])) {
            return;
        }

        $questionerIds = [];
        foreach ($data['questioner_ids'] as $questionerId) {
            $questionerIds[] = [
                'questioner_id' => $questionerId,
            ];
        }

        $item->questioners()->sync($questionerIds);
    }

}
