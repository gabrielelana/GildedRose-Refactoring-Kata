<?php

namespace App;

use PHPUnit\Framework\TestCase;

class GoldenMasterTest extends TestCase
{
    const GOLDEN_MASTER_FIXTURE = __DIR__ . "/../.GOLDEN_MASTER";
    const GOLDEN_MASTER_SCRIPT = __DIR__ . "/../fixtures/texttest_fixture.php";
    const GOLDEN_MASTER_TRIGGER = "GOLDEN_MASTER";
    const GOLDEN_MASTER_DAYS = 30;

    public function testOutputIsStillTheSame()
    {
        $this->maybeCreateGoldenMaster();
        $expectedOutput = $this->previousGoldenMasterOutput();

        $givenOutput = $this->currentGoldenMasterOutput();

        $this->assertEquals($expectedOutput, $givenOutput);
    }

    private function maybeCreateGoldenMaster()
    {
        if ($this->goldenMasterDoesNotExists() || $this->goldenMasterCreationRequested()) {
            $this->createGoldenMaster();
        }
    }

    private function goldenMasterDoesNotExists(): bool
    {
        return !file_exists(self::GOLDEN_MASTER_FIXTURE);
    }

    private function goldenMasterCreationRequested(): bool
    {
        return false !== getenv(self::GOLDEN_MASTER_TRIGGER);
    }

    private function createGoldenMaster(): void
    {
        file_put_contents(self::GOLDEN_MASTER_FIXTURE, $this->currentGoldenMasterOutput());
    }

    private function previousGoldenMasterOutput(): string
    {
        return file_get_contents(self::GOLDEN_MASTER_FIXTURE);
    }

    private function currentGoldenMasterOutput(): string
    {
        return shell_exec(implode(" ", ["php", self::GOLDEN_MASTER_SCRIPT, self::GOLDEN_MASTER_DAYS]));
    }

}
