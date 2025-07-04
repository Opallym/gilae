<?php

namespace App\Command;

use App\Entity\Message;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;   // et ici

class SendFeedbackRequestCommand extends Command
{
    private $reservationRepository;
    private $mailer;
    private $entityManager;

    public function __construct(ReservationRepository $reservationRepository, MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->reservationRepository = $reservationRepository;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('app:send-feedback-request')
            ->setDescription('Envoie un e-mail de demande d\'avis aux clients après leur réservation.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTimeImmutable();

        $reservations = $this->reservationRepository->findByFeedbackToSend($now);

        if (count($reservations) === 0) {
            $output->writeln('Aucune réservation à traiter.');
            return Command::SUCCESS;
        }

        foreach ($reservations as $reservation) {
            $feedbackUrl = sprintf('https://ton-site.com/feedback/%s', $reservation->getToken());

            $htmlContent = <<<HTML
                <div style="font-family: Arial, sans-serif; color: #333;">
                    <h2 style="color:rgb(255, 255, 255);">Merci pour votre réservation</h2>
                    <p>Bonjour {$reservation->getNom()},</p>
                    <p>Nous espérons que votre séjour du <strong>{$reservation->getDateDebut()->format('d/m/Y')}</strong> au <strong>{$reservation->getDateFin()->format('d/m/Y')}</strong> s'est bien passé.</p>
                    <p>Pourriez-vous prendre un moment pour nous laisser votre avis ? Cela ne vous prendra qu’une minute et nous aide énormément à nous améliorer.</p>
                    <p style="margin: 20px 0;">
                        <a href="{$feedbackUrl}" style="background-color:rgb(46, 138, 49); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                            Donner mon avis
                        </a>
                    </p>
                    <p>Merci infiniment,<br>L'équipe Gilaë Conciergerie</p>
                    <hr style="margin-top: 40px;">
                    <small style="color: #888;">Cet e-mail vous a été envoyé automatiquement. Merci de ne pas y répondre.</small>
                </div>
            HTML;

            $email = (new Email())
                ->from('noreply@ton-site.com')
                ->to($reservation->getEmail())
                ->subject('Merci pour votre réservation - Donnez-nous votre avis')
                ->html($htmlContent);

            try {
                $this->mailer->send($email);
                $output->writeln('E-mail envoyé à ' . $reservation->getEmail());

                $reservation->setIsFeedbackSent(true);
                $this->entityManager->persist($reservation);

                // 💬 Enregistrer dans la messagerie
                $message = new Message();
                $message->setSubject($email->getSubject());
                $message->setBody($htmlContent);
                $message->setFromEmail($reservation->getEmail());
                $message->setReceivedAt(new \DateTimeImmutable());
                $message->setIsRead(false);
                $message->setReservation($reservation);
                $message->setReservation($reservation);
                $this->entityManager->persist($message);

            } catch (\Exception $e) {
                $output->writeln('Erreur envoi e-mail à ' . $reservation->getEmail() . ': ' . $e->getMessage());
            }
        }

        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}