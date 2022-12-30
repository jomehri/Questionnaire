<?php

namespace App\Services\Questions;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Questions\QuestionGroup;

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
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        $item = new QuestionGroup();
        $item->setTitle($data[QuestionGroup::COLUMN_TITLE])
            ->save();
    }

}
