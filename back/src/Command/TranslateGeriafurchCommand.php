<?php

namespace App\Command;

use App\Entity\Example;
use App\Entity\Translation;
use App\Entity\WordObject;
use App\Enum\LanguagesEnum;
use App\EventSuscriber\WordWorkflow;
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
        } else {
            $words = $this->wordService->findWordsWithoutTranslation(LanguagesEnum::FR);
        }

        foreach ($words as $word) {
            $output->writeln($word->getText());
            $translation = $this->translate($word);
            if (!empty($translation)) {
                $this->em->persist($translation);
                $this->em->flush();
            }
        }
        return 0;
    }

    private function translate(WordObject $word): ?Translation
    {
        $client = HttpClient::create();
        https://api.geriafurch.bzh/api/search?q=zda&d=frbr
//        $response = $client->request('GET', "https://api.geriafurch.bzh/api/search?q={$word->getText()}&d=frbr");
        $response = $client->request('GET', 'http://apache-rouzig/api/debug/geriafurch');
        $content = json_decode($response->getContent());

        $res = null;

        foreach ($content->results as $src) {
            if ($src->site === "favereau") {
                $translation = $this->parseFavereau($src->translation, $word);
            }

            if ($src->site === "termofis" && isset($translation)) {
                $res = $this->parseTermofis($src->translation, $translation);
            }
        }

        return $res;
    }

    private function parseTermofis(string $string, Translation $translation)
    {
        $escapedString = preg_replace('/\s+/', ' ',$string);
        $examples = explode('<li>',$escapedString);

        foreach ($examples as $example) {
            $example = htmlspecialchars_decode(html_entity_decode(strip_tags($example)), ENT_QUOTES);
            //replace the unwanted chars
            $example = mb_convert_encoding($example, 'UTF-8', 'UTF-8');
            if (!empty($example) && count($exploded = explode('|', $example)) > 1) {
                $from = self::format($exploded[0]);
                $to = self::format($exploded[1]);
                $example = new Example();
                $example
                    ->setFromLanguage($translation->getOriginalWord()->getLanguage())
                    ->setToLanguage($translation->getTranslatedWord()->getLanguage())
                    ->setFromText($from)
                    ->setToText($to)
                ;
                $translation->addExample($example);
            }
        }

        return $translation;
    }

    private function parseFavereau(string $string, WordObject $from)
    {
        $withoutParentheses = preg_replace("/\([^)]+\)/","",$string);

        if (preg_match_all('/<b>(.*?)<\\/b>/', $withoutParentheses, $match) > 0) {
            $text = self::format($match[1][1]);
        } else {
            throw new \Exception();
        }

        $class = get_class($from);
        /** @var WordObject $translationWord */
        $translationWord = new $class();

        $translation = new Translation();

        $translationWord
            ->setText($text)
            ->setLanguage(LanguagesEnum::BR)
        ;
        $translation
            ->setTranslatedWord($translationWord)
            ->setStatus(WordWorkflow::PLACE_REVIEW)
        ;

        $from->addTranslation($translation);

        return $translation;
    }

    private function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    private static function format($string): string
    {
        return mb_strtolower(trim(htmlspecialchars_decode(html_entity_decode($string))));
    }

}