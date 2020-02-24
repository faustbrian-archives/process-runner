<?php

declare(strict_types=1);

/*
 * This file is part of Process Runner.
 *
 * (c) KodeKeep <hello@kodekeep.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KodeKeep\ProcessRunner\ProcessRunners;

use Exception;
use Symfony\Component\Process\Process;
use KodeKeep\ProcessRunner\ShellResponse;
use KodeKeep\ProcessRunner\Contracts\ProcessRunner;

class MockProcessRunner implements ProcessRunner
{
    private ?ShellResponse $response = null;

    private ?Exception $exception = null;

    private ?Process $process = null;

    public function run(Process $process): ShellResponse
    {
        $this->process = $process;

        if ($this->exception) {
            throw $this->exception;
        }

        $this->response->setProcess($process);

        return $this->response;
    }

    public function mock(int $exitCode, string $output, bool $timedOut): void
    {
        $this->response = new ShellResponse($exitCode, $output, $timedOut);
    }

    public function mockException(Exception $exception): void
    {
        $this->exception = $exception;
    }

    public function getProcess(): ?Process
    {
        return $this->process;
    }
}
