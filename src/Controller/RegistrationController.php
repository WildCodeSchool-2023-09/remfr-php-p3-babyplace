<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
<<<<<<< HEAD
use App\Security\EmailVerifier;
=======
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Component\Mailer\MailerInterface;
use App\Security\UserAuthenticator;
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
=======
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
<<<<<<< HEAD
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
=======
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
<<<<<<< HEAD
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@your-domain.com', 'BabyPlace'))
                    ->to($user->getEmail())
                    ->subject('Confirmation mail')
=======
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@example.com', 'BabyPlace'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

<<<<<<< HEAD
            return $this->redirectToRoute('_profiler_home');
=======
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
<<<<<<< HEAD
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
=======
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator,
        UserRepository $userRepository
    ): Response {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
<<<<<<< HEAD
        $this->addFlash('success', 'Félicitations ! Vous pouvez à présent utiliser BabyPlace !');
=======
        $this->addFlash('success', 'Your email address has been verified.');
>>>>>>> bd4228e002249d041a9dd4f4c819cc2473e009c9

        return $this->redirectToRoute('app_register');
    }
}
