<?php

require_once dirname(__DIR__) . '/../3rd_party/random_compat/lib/random.php';

class PasswordGenerator {
    protected $cfg;
    protected $dictionary = null;

    /**
     * PasswordGenerator constructor.
     * @param array $cfg
     */
    public function __construct($cfg)
    {
        $this->cfg = $cfg;
    }

    public function generate() {
        $password = array();
        $wordCount = $this->cfg['pwgen_wordsNumber'];

        for ($i = 0; $i < $wordCount; $i++) {
            $password[] = $this->getRandomWord();
        }

        return implode('-', $password);
    }

    public function getEntropy() {
        return $this->getEntropyPerWord() * $this->cfg['pwgen_wordsNumber'];
    }

    public function getEntropyPerWord() {
        return (int) (log(count($this->dictionary) - 1, 2));
    }

    public function getRandomWord() {
        if ($this->dictionary === null) {
            $this->loadDictionary();
        }

        $wordCount = count($this->dictionary) - 1;
        $randInt = random_int(0, $wordCount);
        return $this->dictionary[$randInt];
    }

    private function loadDictionary() {
        $path = $this->cfg['pwgen_dictionaryFilePath'];
        if (strlen($path) && file_exists($path)) {
            $file = file_get_contents($path);
            $this->dictionary = preg_split("/\r\n|\n|\r/", $file);
        }
    }
}