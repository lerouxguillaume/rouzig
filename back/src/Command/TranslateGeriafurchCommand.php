<?php

namespace App\Command;

use App\Service\WordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class TranslateGeriafurchCommand extends Command
{
    protected static $defaultName = 'app:import:geriafurch';

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
            ->setDescription('Search geriafurch')
            ->addArgument('word', InputArgument::OPTIONAL, 'word to translate')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $word = $input->getArgument('word');

        if (!empty($word)) {
            $words = $this->wordService->search($word);
            $this->translate($word);

            foreach ($words as $word) {
            }
        } else {
            $output->writeln('<error>TODO</error>');
        }

        return 0;
    }

    private function translate($word)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://apache-rouzig/api/debug/geriafurch');
        $content = json_decode($response->getContent());

        foreach ($content->results as $src) {
            if ($src->site === "favereau") {
                $res = $this->parseFavereau($src->translation);
            }
            if ($src->site === "termofis") {
                $res = $this->parseTermofis($src->translation, $res);
            }
        }
        dump($res);die();
    }

    private function parseTermofis(string $string, $context)
    {
        $escapedString = preg_replace('/\s+/', ' ',$string);
        $examples = explode('<li>',$escapedString);

        foreach ($examples as $example) {
            $example = trim(htmlspecialchars_decode(html_entity_decode(strip_tags($example)), ENT_QUOTES));
            $example = mb_convert_encoding($example, 'UTF-8', 'UTF-8');
            if (!empty($example)) {
                dump($example);
            }
        }
        die();
    }

    private function parseFavereau(string $string)
    {
        $withoutParentheses = preg_replace("/\([^)]+\)/","",$string);

        $res = [];

        $dom = new \DOMDocument();
        $dom->loadHTML($withoutParentheses);

        $matches= $dom->getElementsByTagName('li');
        /** @var \DOMElement $match */
        foreach ($matches as $match) {
            $parts = $match->getElementsByTagName('b');
            $src = self::formatNode($parts->item(0));
            $translation = self::formatNode($parts->item(1));

            $res[] = [$src => [], $translation=> []];
        }
        return $res;
    }

    private static function formatNode(\DOMNode $node): string
    {
        return mb_strtolower($node->nodeValue);
    }

}