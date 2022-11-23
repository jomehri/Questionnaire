<?php

namespace Tests\Feature\User;

use Tests\BaseTest;
use App\Models\Basic\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\UserPinCodeNotification;

class UserTest extends BaseTest
{

    /**
     * @return void
     */
    public function test_user_register_header_not_accessible_by_get_request(): void
    {
        $this->getJson("api/user/register")->assertStatus(405);
    }

    /**
     * @return void
     */
    public function test_user_register_fail_if_no_body_provided(): void
    {
        $this->postJson("api/user/register")->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_register_successfully_added_into_database(): void
    {
        $data = [
            'mobile' => '09123456789'
        ];

        $this->postJson("api/user/register", $data)->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_user_register_mobile_is_required(): void
    {
        $data = [
            'first_name' => 'ali' // no mobile number provided
        ];

        $this->postJson("api/user/register", $data)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_register_mobile_format_validation(): void
    {
        $data = [
            'mobile' => '1456789' // wrong mobile number
        ];

        $this->postJson("api/user/register", $data)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_register_first_name_too_lage_exception(): void
    {
        $data = [
            'first_name' => 'alialialialialialialialialialialialialialiallialialialialialiali', // too long
            'mobile' => '09123456789' // correct
        ];

        $this->postJson("api/user/register", $data)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_register_last_name_too_lage_exception(): void
    {
        $data = [
            'first_name' => 'ali', // correct
            'last_name' => 'alialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialialiali', // too long
            'mobile' => '09123456789' // correct
        ];

        $this->postJson("api/user/register", $data)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_register_notification_sent(): void
    {
        Notification::fake();

        $data = [
            'mobile' => '09123456789' // correct
        ];

        $this->postJson("api/user/register", $data);

        $user = User::getUserByMobile($data['mobile']);

        Notification::assertSentTo($user, UserPinCodeNotification::class);
    }

}
