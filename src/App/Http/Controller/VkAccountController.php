<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\VkAccount\VkAccountService;
use App\Http\Response\Output\ResourceListOutput;
use App\Http\Response\Output\ResourceOutput;
use App\Http\Response\Output\VkAccount\VkAccountLinkOutput;
use App\Http\Request\Input\VkAccount\CreateVkAccountInput;
use App\Http\Response\Output\IdOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VkAccountController extends AbstractController
{
    public function __construct(
        private VkAccountService $vkAccountService,
    ) {
    }

    #[Route('/v1/vk-accounts', methods: 'GET', name: 'api.v1.vkAccounts.index')]
    public function index(): JsonResponse
    {
        $user = $this->getUser();

        $vkAccountList = $this->vkAccountService->findAll($user);

        return $this->jsonOutput(new ResourceListOutput($vkAccountList));
    }

    #[Route('/v1/vk-accounts/{id<\d+>}', methods: 'GET', name: 'api.v1.vkAccounts.single')]
    public function single(int $id): JsonResponse
    {
        $user = $this->getUser();

        $vkAccount = $this->vkAccountService->findOneById($user, $id);

        return $this->jsonOutput(new ResourceOutput($vkAccount));
    }

    #[Route('/v1/vk-accounts/link', methods: 'GET', name: 'api.v1.vkAccounts.link')]
    public function link(): JsonResponse
    {
        $link = $this->vkAccountService->getCreationLink();

        return $this->jsonOutput(new VkAccountLinkOutput($link));
    }

    #[Route('/v1/vk-accounts/create', methods: ['GET', 'POST'], name: 'api.v1.vkAccounts.create')]
    public function create(CreateVkAccountInput $input): JsonResponse
    {
        $vkId = $input->getUserId();
        $accessToken = $input->getAccessToken();

        $user = $this->getUser();

        $vkAccount = $this->vkAccountService->create($user, $vkId, $accessToken);

        return $this->jsonOutput(new ResourceOutput($vkAccount));
    }

    #[Route('/v1/vk-accounts/{id<\d+>}', methods: 'DELETE', name: 'api.v1.vkAccounts.delete')]
    public function delete(int $id): JsonResponse
    {
        $user = $this->getUser();

        $this->vkAccountService->delete($user, $id);

        return $this->jsonOutput(new IdOutput($id));
    }
}
