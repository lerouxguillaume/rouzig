<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Word\Adjective;
use App\Entity\Word\Adverb;
use App\Entity\Word\Noun;
use App\Entity\Word\Other;
use App\Entity\Word\Preposition;
use App\Entity\Word\Pronoun;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Enum\LanguagesEnum;
use App\Service\WordService;
use Doctrine\ORM\EntityManagerInterface;
use SplFileObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLexiqCommand extends Command
{
    protected static $defaultName = 'app:import:lexiq';

    /** @var WordService */
    private $wordService;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * ImportLexiqCommand constructor.
     * @param WordService $wordService
     * @param EntityManagerInterface $em
     */
    public function __construct(WordService $wordService, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->wordService = $wordService;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Import the lexiq csv file')
            ->addArgument('path', InputArgument::REQUIRED, 'path to the file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        if (empty($path) || is_file($path)) {
            $output->writeln('<error>Invalid path parameter</error>');
        }

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Import lexiq',
            '============',
            '',
        ]);

        $lexiqUser = $this->em->getRepository(User::class)->findOneBy(['username' => 'Lexiq']);
        if (empty($lexiqUser)) {
            $lexiqUser = new User();
            $lexiqUser
                ->setUsername('Lexiq')
                ->setIsActive(false)
                ->setPassword('')
                ->setEmail('Lexiq')
            ;

            $this->em->persist($lexiqUser);
            $this->em->flush();
        }

        $file = new SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        $numberOfRow = $file->key();
        $progressBar = new ProgressBar($output, $numberOfRow);

        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);
        $file->setCsvControl("\t");
        $header = true;
        foreach ($file as $row) {
            if ($header || $row === false) {
                $header = false;
                continue;
            }
            $progressBar->advance();
            $lemme = $row[2];
            $cgram = $row[3];
            $genre = $row[4];
            $nombre = $row[5];
            $wordType = $this->wordTypeMapper($cgram);

            if (in_array($wordType, [Noun::class, Pronoun::class, Adjective::class]) &&
                $genre === 'f' && $nombre === 's'
            ) {
                $lemme = $row[0];
            }
            $word = $this->importWord($lemme, $wordType, $genre);

            if (!$word) {
                /** @var WordObject $word */
                $word = new $wordType();

                $word
                    ->setText($lemme)
                    ->setLanguage(LanguagesEnum::FR)
                    ->setAuthor($lexiqUser)
                ;

                if ($word instanceof Other) {
                    $word->setTypeName($cgram);
                }

                if (in_array($wordType, [Noun::class, Pronoun::class, Adjective::class])) {
                    $word
                        ->setGenre($genre)
                        ->setPlural($nombre)
                    ;
                }

                $this->em->persist($word);
                $this->em->flush();
            }

            if ($progressBar->getProgress() % 500 === 0) {
                $this->em->clear();
                $lexiqUser = $this->em->getRepository(User::class)->findOneBy(['username' => 'Lexiq']);
            }
        }

        $progressBar->finish();
        $output->writeln(null);
        return 0;
    }

    private function importWord($lemme, $type, $genre)
    {
        return current($this->wordService->findByCriteria($lemme, $type, $genre));
    }

    private function wordTypeMapper($cgram): string
    {
        switch ($cgram) {
            case 'VER':
                return Verb::class;
            case 'NOM':
                return Noun::class;
            case 'ADV':
                return Adverb::class;
            case 'ADJ':
                return Adjective::class;
            case 'PRE':
                return Preposition::class;
        }
        return Other::class;
    }
}