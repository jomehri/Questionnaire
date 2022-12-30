<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Questions\QuestionGroup;
use Illuminate\Support\Facades\DB;

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
            if (!empty($data['questioner_ids'])) {
                $questionerIds = [];
                foreach ($data['questioner_ids'] as $questionerId) {
                    $questionerIds[] = [
                        'questioner_id' => $questionerId,
                    ];
                }

                $item->questioners()->sync($questionerIds);
            }
        });
    }

}
