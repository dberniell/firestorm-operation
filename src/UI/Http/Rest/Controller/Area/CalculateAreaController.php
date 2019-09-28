<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Area;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use App\UI\Http\Rest\Controller\CommandController;
use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CalculateAreaController extends CommandController
{
    /**
     * @Route(
     *     "/calculateArea",
     *     name="calculate_area",
     *     methods={"POST"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Area calculated successfully"
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
     *     name="area",
     *     type="string",
     *     in="body",
     *     schema=@SWG\Schema(type="area",
     *         @SWG\Property(property="uuid", type="string"),
     *         @SWG\Property(property="divider", type="string"),
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
        $uuid = $request->get('uuid')?: Uuid::uuid4()->toString();
        $natural = (int) $request->get('divider');

        Assertion::notNull($natural, "Natural number can\'t be null");

        $commandRequest = new CalculateAreaCommand($uuid, $natural);

        $this->exec($commandRequest);

        $response = [
            "uuid" => $uuid,
            "natural" => $natural
        ];
        return JsonResponse::create($response, JsonResponse::HTTP_CREATED);
    }
}
