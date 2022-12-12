<?php

namespace App\Command;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MailService;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

#[AsCommand(name: 'app:draw-secret-senta', description: 'Draw secret senta', aliases: ["d:s:s"])]
class DrawSecretSentaCommand extends Command
{
    const USERS_ARGUMENT = 'users';
    const COMMA = ',';
    const PIPE = '|';

    /**
     * @param User[] $users
     */
    private array $users;

    private OutputInterface $output;


    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserRepository     $userRepository,
        private readonly MailService        $mailService,
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        // validate input
        try {
            $this->users = $this->validateInput($input);
        } catch (Throwable $th) {
            $this->reportErrorInConsole($th);
            return Command::INVALID;
        }
        try {
            $this->drawSecretSenta();
            //
            $this->save();
            //
            $this->sendMails();
        } catch (Throwable $th) {
            $this->reportErrorInConsole($th);
            return Command::FAILURE;
        }

        $output->writeln('<info>🎅 Done 🎅</info>');
        return Command::SUCCESS;
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument(self::USERS_ARGUMENT, InputArgument::REQUIRED, 'format : "name,email|name,email|..."');
    }


    /**
     * @return User[]
     * @throws Exception
     */
    private function validateInput(InputInterface $input): array
    {
        $input = $input->getArgument(self::USERS_ARGUMENT);
        $userInformations = explode(self::PIPE, $input);
        $users = [];
        foreach ($userInformations as $userInformation) {
            // hydrate
            $user = new User();
            [$name, $email] = explode(self::COMMA, $userInformation);
            $user->setName($name)->setEmail($email);
            // validate
            $violations = $this->validator->validate($user);
            if (count($violations) > 0) {
                throw new Exception((string)$violations);
            }
            //
            $users[] = $user;
        }
        // no duplicate email
        $emails = array_map(fn(User $user) => $user->getEmail(), $users);
        if (count($emails) !== count(array_unique($emails))) {
            throw new Exception('There is duplicate email');
        }

        return $users;
    }

    private function drawSecretSenta()
    {
        $this->output->writeln('<info>🎅 Draw secret senta 🎅</info>');
        shuffle($this->users);
        $this->output->writeln('<info>' . count($this->users) . ' users</info>');
        // associate each user to another user
        /* @var $user User */
        foreach ($this->users as $key => $user) {
            // if last user, associate to first user
            $randomUser = $this->users[$key + 1] ?? $this->users[0];
            $user->setGiveTo($randomUser);

            if ($this->output->isVerbose()) {
                $this->output->writeln('<info>🎄 ' . $user->getName() . ' give to ' . $randomUser->getName() . ' 🎄</info>');
            }
        }
    }

    /**
     * @param Throwable $e
     * @return void
     */
    private function reportErrorInConsole(Throwable $e): void
    {
        $outputStyle = new OutputFormatterStyle('#F00', '#FFF', ['bold', 'blink']);
        $this->output->getFormatter()->setStyle('fire', $outputStyle);
        $this->output->writeln('<fire>' . $e->getMessage() . '</fire>');
    }


    private function sendMails()
    {
        $progressBar = new ProgressBar($this->output, count($this->users));
        $progressBar->start();
        foreach ($this->users as $user) {
            try {
                $this->mailService->sendSantaClausMail($user);
            } catch (Throwable $th) {
                $this->reportErrorInConsole($th);
            }
            //
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    /**
     * Save user with their secret senta
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     */
    private function save(): void
    {
        $this->userRepository->saveManyWithTransaction($this->users);
    }
}
