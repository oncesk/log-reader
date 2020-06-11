<?php

namespace Oncesk\LogReader\Tests\Integration;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @var string
     */
    private $parser = __DIR__ . '/../../bin/parser.php';

    /**
     * @var string
     */
    private $testFile = __DIR__ . '/../../resources/test.log';

    public function testParser()
    {
        $expectedOutput =<<<OUT
list of webpages with most page views ordered from most pages views to less page views
/index 2 visits
/contact 2 visits
/index/1 1 visits

list of webpages with most unique page views also ordered
/index 2 unique views
/contact 1 unique views
/index/1 1 unique views
OUT;
        list($status, $output) = $this->execute([$this->testFile]);
        $this->assertEquals(0, $status);
        $this->assertEquals($output, $expectedOutput);
    }

    public function testFileNotPassed()
    {
        list($status, $output) = $this->execute();
        $this->assertEquals(1, $status);
        $this->assertEquals('Please, specify a log file!', $output);
    }

    public function testFileNotFound()
    {
        list($status, $output) = $this->execute([$this->testFile . 'not_found']);
        $this->assertEquals(2, $status);
        $this->assertEquals('Error: No such file', $output);
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function execute(array $arguments = []): array
    {
        $command = sprintf(
            'php %s %s',
            $this->parser,
            implode(' ', $arguments)
        );
        exec($command, $output, $status);
        return [$status, implode("\n", $output)];
    }
}
