<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part;
namespace App\Integration\VKontakte\Part;

use App\Integration\VKontakte\Interface\WallApiInterface;
use App\Integration\VKontakte\Part\AbstractPartApi;
use App\Integration\VKontakte\Response\Output\Wall\PostIdOutput;

/**
 * @internal For App\Integration\VKontakte
 */
class WallApi extends AbstractPartApi implements WallApiInterface
{
    public function postToGroup(string $token, int $groupId, string $message): PostIdOutput
    {
        // If owner_id is a group, it must start with a minus.
        $correctGroupId = "-$groupId";

        $responseData = $this->requestSuccessful('wall.post', $token, [
            'message' => $message,
            'owner_id' => $correctGroupId,
        ])->toArray();

        return PostIdOutput::fromBodyData($responseData);
    }
}
