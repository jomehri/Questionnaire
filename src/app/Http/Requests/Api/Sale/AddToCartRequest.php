<?php

namespace App\Http\Requests\Api\Sale;

use App\Models\Questions\Questioner;
use App\Models\Sale\Order;
use App\Models\Sale\OrderItem;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AddToCartRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validations rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            OrderItem::COLUMN_QUESTIONER_ID => [
                'required',
                'integer',
                'exists:questioners,id',
                function ($key, $value, $fail) {
                    $this->verifyQuestionerIsBuyAble($value, $fail);
                }
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            OrderItem::COLUMN_QUESTIONER_ID . '.required' => __("sale/sale.validations.questionerIdIsRequired"),
            OrderItem::COLUMN_QUESTIONER_ID . '.integer' => __("sale/sale.validations.questionerIdMustBeInteger"),
            OrderItem::COLUMN_QUESTIONER_ID . '.exists' => __("sale/sale.validations.questionerDoesNotExist"),
        ];
    }

    /**
     * @param $value
     * @param $fail
     * @return void
     */
    function verifyQuestionerIsBuyAble($value, $fail): void
    {
        if (!is_numeric($value)) {
            return;
        }

        /** @var Questioner $questioner */
        $questioner = Questioner::find($value);

        if (!$questioner) {
            return;
        }

        /**
         * Is it free?
         */
        if ($questioner->isFree()) {
            $fail(__("sale/sale.validations.questionerIsAlreadyFree"));
        }

        /**
         * Is it already paid?
         */
        if (Questioner::userPaidForQuestioner($value)) {
            $fail(__("sale/sale.validations.youAlreadyPaidForThisQuestioner"));
        }

        /**
         * Is it in current cart already?
         */
        if (Questioner::isQuestionerAlreadyInCurrentCart($value)) {

            $fail(__("sale/sale.validations.questionerAlreadyInYourCurrentCart"));
        }
    }

}
