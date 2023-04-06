<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part\UsersApi;

use App\Integration\VKontakte\Interface\UsersApiInterface;
use App\Integration\VKontakte\Part\AbstractPartApi;
use App\Integration\VKontakte\Part\UsersApi\Output\UserOutput;

/**
 * @internal For App\Integration\VKontakte
 */
class UsersApi extends AbstractPartApi implements UsersApiInterface
{
    /**
     * @param ?int $id User id. If is not passed, $token owner will be returned.
     */
    public function get(string $token, int $id = null): UserOutput
    {
        $params = [
            'fields' => ['domain'],
        ];

        if ($id) {
            $params['user_ids'] = $id;
        }

        $response = $this->requestSuccessful('users.get', $token, $params);

        return UserOutput::fromResponse($response);
    }
}
