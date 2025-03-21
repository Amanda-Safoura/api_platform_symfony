<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class CreateUserProcessor implements ProcessorInterface
{
    private $entityManager;
    private $user_password_hasher;
    private $mailer;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $user_password_hasher,
        MailerInterface $mailer
    ) {
        $this->entityManager = $entityManager;
        $this->user_password_hasher = $user_password_hasher;
        $this->mailer = $mailer;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!$data instanceof User) return $data;

        $length = 12; // Length of the random string
        $password = bin2hex(random_bytes($length / 2));
        $data->setPassword($this->user_password_hasher->hashPassword($data, $password));

        $email = (new TemplatedEmail())
            ->from('support@audit-master.com')
            ->to($data->getEmail())
            ->priority(Email::PRIORITY_NORMAL)
            ->subject('Here your credentials for Audit Master!')
            // path of the Twig template to render
            ->htmlTemplate('mails/login_credentials.html.twig')
            // pass variables (name => value) to the template
            ->context([
                'user' => $data,
                'plain_password' => $password
            ]);


        $this->mailer->send($email);

        // Persistance des données
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
