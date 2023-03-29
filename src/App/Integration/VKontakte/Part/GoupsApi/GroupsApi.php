<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part\GoupsApi;

use App\Integration\VKontakte\Interface\GroupsApiInterface;
use App\Integration\VKontakte\Part\AbstractPartApi;
use App\Integration\VKontakte\Part\GoupsApi\Output\GroupOutput;

/**
 * @internal For App\Integration\VKontakte
 */
class GroupsApi extends AbstractPartApi implements GroupsApiInterface
{
    /**
     * @param int|string $id Id or url slug.
     */
    public function getById(string $token, int|string $id): GroupOutput
    {
        $responseData = $this->requestSuccessful('groups.getById', $token, [
            'group_id' => $id,
        ])->toArray();

        return GroupOutput::fromBodyData($responseData);
    }
}
