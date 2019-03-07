<?php


namespace Oloid\Services;


use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class GitService
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * GitService constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }


    /**
     * Get the current git branch of the project
     * @return string
     */
    public function getCurrentBranch(): string
    {
        /*
         * If there is no .git folder, return. There is no current branch.
         */
        if (!$this->filesystem->exists(base_path('../.git'))) {
            return '';
        }

        /*
         * Get the current git branch
         */
        $process = new Process('git rev-parse --abbrev-ref HEAD',
            base_path(),
            null,
            null,
            600);
        $process->run();

        return trim($process->getOutput());
    }
}