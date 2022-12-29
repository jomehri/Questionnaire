<?php

namespace App\Services\Questions;

use App\Exceptions\Questions\QuestionerWithQuestionsCantBeDeletedException;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Models\Questions\Questioner;

class QuestionerService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            Questioner::COLUMN_TITLE => $request->post('title'),
            Questioner::COLUMN_SLUG => $request->post('slug'),
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        $item = new Questioner();
        $item->setTitle($data[Questioner::COLUMN_TITLE])
            ->setSlug($data[Questioner::COLUMN_SLUG])
            ->save();
    }

    /**
     * @param Questioner $questioner
     * @param array $data
     * @return void
     */
    public function update(Questioner $questioner, array $data): void
    {
        $questioner->setTitle($data[Questioner::COLUMN_TITLE])
            ->setSlug($data[Questioner::COLUMN_SLUG])
            ->save();
    }

    /**
     * @param Questioner $questioner
     * @return void
     * @throws QuestionerWithQuestionsCantBeDeletedException
     */
    public function delete(Questioner $questioner): void
    {
        // TODO @aliJo check no question groups are assigned to this questioner, else throw error
        if (1 === 2) {
            throw new QuestionerWithQuestionsCantBeDeletedException();
        }

        $questioner->delete();
    }

}
