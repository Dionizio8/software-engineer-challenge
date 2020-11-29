<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

abstract class BaseCommandCsv extends Command
{
    /**
     * Limit Chunk
     * 
     * @var int
     */
    public $limitChunk = 50;

    /**
     * File header
     * 
     * @var array
     */
    protected $header = [];

    /**
     * File to be treated
     * 
     * @var string
     */
    protected $file;

    /**
     * Line counter on the interator
     * 
     * @var int
     */
    public $lineCount;

    /**
     * Total file line count
     * 
     * @var int
     */
    public $totalLineCount;

    /**
     * Count all lines file.
     * 
     * @return int
     */
    public static function countAllLinesFile($file): int
    {
        $countLines = 0;

        $file = fopen($file, "r");
        while ((fgets($file)) !== false) {
            $countLines++;
        }
        fclose($file);

        return $countLines;
    }

    /**
     * Action performed at each interaction
     */
    abstract public function interactionAction(array $chunk);

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set File
     */
    public function setFile(string $file)
    {
        if (!file_exists($file)) {
            throw new Exception("The {$file} file does not exist.");
        }

        $this->file = $file;
    }

    /**
     * Starts control interaction
     */
    public function startInteraction()
    {
        $this->totalLineCount = self::countAllLinesFile($this->file);

        $handle = fopen($this->file, 'r');

        $chunk = [];

        if (!$handle) {
            throw new Exception("Could not initialize the file.");
        }

        while ($line = fgetcsv($handle)) {
            $this->lineCount++;

            $chunk[] = $this->lineCast($line);

            if ((count($chunk) === $this->limitChunk) || ($this->lineCount === $this->totalLineCount)) {

                $this->interactionAction($chunk);

                $chunk = [];
            }
        }

        fclose($handle);
    }

    /**
     * Line Cast Array
     */
    public function lineCast($line): ?array
    {
        if (count($line) !== count($this->header)) {
            throw new Exception("Casting error line {$this->lineCount}.");
        }

        return array_combine($this->header, $line);
    }
}
