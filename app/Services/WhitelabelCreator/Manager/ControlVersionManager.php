<?php


namespace App\Services\WhitelabelCreator\Manager;


use App\Services\WhitelabelCreator\Contracts\BladeCreatorInterface;
use App\Services\WhitelabelCreator\Contracts\ControlVersionManagerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GrahamCampbell\GitHub\GitHubManager;

class ControlVersionManager implements ControlVersionManagerInterface
{
    const VIEW_SITE_PATH = 'resources/views/sites/';

    private $github;
    private $bladeCreator;

    public function __construct(
        GitHubManager $github,
        BladeCreatorInterface $bladeCreator
    ) {
        $this->github = $github;
        $this->bladeCreator = $bladeCreator;
    }

    public function createNewPullRequest($input)
    {
        $parentDirectory = $this->getDirectory($input['parentSite']);
        $fileExists = $this->github->api('repo')->contents()->exists(env('GITHUB_OWNER'), env('GITHUB_REPOSITORY'), $parentDirectory, env('GITHUB_BRANCH'));
        if (!$fileExists) {
            throw new ModelNotFoundException('This directory does not exist:' . $parentDirectory);
        }
        $oldFiles = $this->show($parentDirectory);
        $this->bladeCreator->copy($oldFiles, $input);
    }

    public function createRull($input)
    {
        $committer = array('name' => $input['creator'], 'email' => $input['creatorEmail']);
        $this->github->api('repo')->contents()->update(env('GITHUB_OWNER'), env('GITHUB_REPOSITORY'), $input['path'], $input['content'], $input['nameNewSite'], $input['sha'], env('GITHUB_BRANCH'), $committer);
    }


    public function getDirectory($siteName)
    {
        return self::VIEW_SITE_PATH . str_replace('.', '-', $siteName);
    }

    public function show($directory)
    {
        return $this->github->api('repo')->contents()->show(env('GITHUB_OWNER'), env('GITHUB_REPOSITORY'), $directory, env('GITHUB_BRANCH'));
    }
}
