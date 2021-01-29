<?php


namespace App\Services\WhitelabelCreator\Manager;


use App\Repositories\Contracts\OauthClientsInterface;
use App\Services\WhitelabelCreator\Contracts\BladeCreatorInterface;
use App\Services\WhitelabelCreator\Contracts\ControlVersionManagerInterface;
use Illuminate\Support\Arr;

class BladeCreator implements BladeCreatorInterface
{
    const BUILD_PATH = 'projects-families-to-build.js';
    const IGNORE_FILES = [
        'assets-config.js',
        'main.scss'
    ];

    private $oauthClients;
    private $manager;

    public function __construct(
        OauthClientsInterface $oauthClients
    ) {
        $this->oauthClients = $oauthClients;
    }

    public function copy($oldFiles, $input)
    {
        $this->manager = app()->make(ControlVersionManagerInterface::class);
        foreach ($oldFiles as $oldFile) {
            if (!$this->pagesFilter($oldFile['name'], $input)|| $oldFile['type'] == 'dir') {
                continue;
            }
            $file = $this->manager->show($oldFile['path']);
            $path = str_replace($this->manager->getDirectory($input['parentSite']), $this->manager->getDirectory($input['nameNewSite']), $oldFile['path']);
            $content = base64_decode($file['content']);
            if ($oldFile['name'] == 'assets-config.js') {
                $content = $this->changeConfigJs($content, $input);
                $this->changeProjectsFamiliesToBuild($input);
            }
            $this->manager->createRull(['path' => $path, 'content' => $content, 'sha' => $oldFile['sha'], 'nameNewSite' => $input['nameNewSite'], 'creator' => $input['creator'], 'creatorEmail' => $input['creatorEmail']]);
        }
    }

    private function pagesFilter($fileName, $input)
    {
        if (in_array($fileName, self::IGNORE_FILES)) {
            return true;
        }
        if (strpos($fileName, '.blade.php') === false) {
            $this->force($fileName, $input);
        }
        return Arr::get((array)$input['pages'], substr($fileName, 0, strpos($fileName, ".")), true);
    }

    private function changeConfigJs($content, $input)
    {
        return str_replace(str_replace('.', '-', $input['parentSite']), str_replace('.', '-', $input['nameNewSite']), $content);
    }

    private function force($directory, $input)
    {
        $this->manager = app()->make(ControlVersionManagerInterface::class);
        $oldFiles = $this->manager->show($this->manager->getDirectory($input['parentSite']) . '/' . $directory);
        foreach ($oldFiles as $oldFile) {
            if (strpos($oldFile['name'], '.blade.php') === false) {
                $this->force($directory . '/' . $oldFile['name'], $input);
            }
            if ($oldFile['type'] == 'dir') {
                continue;
            }
            return $this->copy([$oldFile], $input);
        }
    }

    private function changeProjectsFamiliesToBuild($input)
    {
        $this->manager = app()->make(ControlVersionManagerInterface::class);
        $parentAbbreviation = strtolower($this->oauthClients->getAbbreviationBySiteName($input['parentSite']));
        $parentSite = $this->changeDirectory($input['parentSite']);
        $nameNewSite = $this->changeDirectory($input['nameNewSite']);
        $this->manager = app()->make(ControlVersionManagerInterface::class);
        $file = $this->manager->show(self::BUILD_PATH);
        $content = base64_decode($file['content']);
        $array = explode("//" . $parentAbbreviation . "\n", $content);
        $array[1] = "const " . $this->changeDirectory($input['nameNewSite']) . " = require(__dirname + entryRootSites + '" . str_replace('.', '-', $input['nameNewSite']) . "/assets-config')\n" . $array[1];
        $content = implode('//' . $parentAbbreviation . "\n", $array);
        $array = explode($parentSite . ': ' . $parentSite . '(outputRootSites),' . "\n", $content);
        $array[1] = "    " . $nameNewSite . ': ' . $nameNewSite . "(outputRootSites),\n" . $array[1];
        $content = implode($parentSite . ': ' . $parentSite . '(outputRootSites),' . "\n", $array);
        $this->manager->createRull(['path' => self::BUILD_PATH, 'content' => $content, 'sha' => $file['sha'], 'nameNewSite' => $input['nameNewSite'], 'creator' => $input['creator'], 'creatorEmail' => $input['creatorEmail']]);
    }

    private function changeDirectory($siteName)
    {
        return str_replace('.', '_', $siteName);
    }
}

