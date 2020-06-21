<?php
declare(strict_types=1);

namespace Susanne\SystemStatus;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\CommandUtility;


class ShowGitRevision
{

    public function __invoke(SystemInformationToolbarCollectorEvent $systemInformation)
    {
        $systemInformation->getToolbarItem()->addSystemInformation(...$this->getGitRevision());
    }

    /**
     * Gets the current GIT version
     */
    protected function getGitRevision(): array
    {
        chdir(Environment::getProjectPath());
        $revision = trim(CommandUtility::exec('git describe --tags'));
        chdir(Environment::getBackendPath());
        return [
            htmlspecialchars('Site Version', ENT_QUOTES | ENT_HTML5),
            htmlspecialchars($revision, ENT_QUOTES | ENT_HTML5),
            'information-git',
        ];
    }

}
