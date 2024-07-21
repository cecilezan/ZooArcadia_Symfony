<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Response as OAResponse;



#[Route('/api', name: 'app_api_')]
class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private UserRepository $repository,
        private SerializerInterface $serializer)
    {
    }

    #[Route('/registration', name: 'registration', methods: ['POST'])]

    #[OA\Post(
        path:"/api/registration",
        summary: "Inscription d'un nouvel utilisateur",
        requestBody: new RequestBody(
            required: true,
            description: "Données de l'utilisateur à inscrire",
            content: [new Mediatype(mediaType:"application/json",
                schema: new Schema(type:"object", properties:[new Property(
                    property: "email",
                    type: "string",
                    example: "john@doe.com"
                ),
                    new Property(
                        property: "password",
                        type: "string",
                        example: "Mot de passe"
                    )]))]
        )/*,
        responses: new OAResponse(
            response: 201,
            description: "Utilisateur inscrit avec succès",
            content: [new MediaType(mediaType:"application/json",
            schema: new Schema(type:"object", properties:[new Property(
                property: "user",
                type: "string",
                example: "john@doe.com"
                ),
                    new Property(
                        property: "apiToken",
                        type: "string",
                        example :"5ec84856df78ba8cdcecea5fe1e749edb83a6d4a292b89b62fad2720cdb89a6f"
                    ),
                    new Property(
                        property: "roles",
                        type: "array",
                        example: ["ROLE_USER"]
                    )]))]
        )*/
    )]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(),User::class, 'json');
        $user->setPassword($passwordHasher->hashPassword($user,$user->getPassword()));
        $user->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($user);
        $this->manager->flush();

        return new JsonResponse(
            ['user'=> $user->getUserIdentifier(), 'apiToken'=>$user->getApiToken(), 'roles'=>$user->getRoles()],
            Response::HTTP_CREATED);
    }

    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user){
            return new JsonResponse(
                ['message' => 'missing credentials'],
                Response::HTTP_UNAUTHORIZED);
        }


        return new JsonResponse([
            'user'=> $user->getUserIdentifier(),
            'apiToken'=>$user->getApiToken(),
            'roles'=>$user->getRoles()
        ]);
    }

    #[Route('/registration/list', name: 'showAll', methods: 'GET')]
    public function showAll(): JsonResponse
    {
        $users = $this->repository->findAll();
        $dataUserList = array();
        foreach ($users as $user) {
            $dataUser = $this->serializer->serialize($user, 'json');
           /* [
                'id'=> $user->getId(),
                'name'=> $user->getName(),
                'prenom'=> $user->getPrenom(),
                'email'=> $user->getEmail(),
                'roles'=>$user->getRoles()
            ]);*/
            array_push($dataUserList, $dataUser);

        }
        return new JsonResponse($dataUserList, Response::HTTP_OK);

    }


    #[Route('/registration/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);
        if($user) {
            $responseData = $this->serializer->serialize($user, 'json');
            return new JsonResponse($responseData, Response::HTTP_OK, [], true);

        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    #[Route('/registration/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);

        if ($user){
            $user = $this->serializer->deserialize($request->getContent(),
                User::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

            $this->manager->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND, [], true);
    }
    #[Route('/registration/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $id]);

        if($user){
            $responseData = $this->serializer->serialize($user, 'json');
            if(!in_array("ROLE_ADMIN", $user->getRoles())){
                $this->manager->remove($user);
                $this->manager->flush();
            }
            return new JsonResponse(null, Response::HTTP_FORBIDDEN);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);

    }
}


