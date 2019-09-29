<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Area;

use App\Application\Query\Area\GetAreaById\GetAreaByIdQuery;
use App\UI\Http\Rest\Controller\QueryController;
use Assert\Assertion;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetAreaByIdController extends QueryController
{
    /**
     * @Route(
     *     "/getAreaById",
     *     name="get_area_by_id",
     *     methods={"POST"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Area retrieved successfully"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Conflict"
     * )
     * @SWG\Parameter(
     *     name="uuid",
     *     type="string",
     *     in="body",
     *     schema=@SWG\Schema(type="string",
     *         @SWG\Property(property="uuid", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="Area")
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uuid = $request->get('uuid');

        Assertion::notNull($uuid, "Uuid can\'t be null");

        $commandRequest = new GetAreaByIdQuery($uuid);

        $area = $this->ask($commandRequest);

        return $this->json($area, [$this, 'formatResponse']);
    }

    public function formatResponse($key)
    {
        return in_array($key, ['area', 'weather']);
    }
}
