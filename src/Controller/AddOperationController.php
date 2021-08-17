<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\BankAccount;
use App\Entity\BankOperation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AddOperationController extends AbstractController
{
    public function __invoke(
        BankAccount $data,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        Request $request,
        SerializerInterface $serializer
    ): BankOperation {

        $validator->validate($data);
        $json = $request->getContent();
        $bankOperation = $serializer->deserialize($json, BankOperation::class, 'json');
        $validator->validate($bankOperation);
        $data->addBankOperation($bankOperation);
        $entityManager->persist($bankOperation);
        $entityManager->flush();

        return $bankOperation;
    }
}
