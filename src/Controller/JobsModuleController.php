<?php

declare(strict_types=1);

/*
 * This file is part of Jobs Bundle.
 * 
 * (c) Hamid Abbaszadeh 2021 <abbaszadeh.h@gmail.com>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/respinar/contao-jobs-bundle
 */

namespace Respinar\ContaoJobsBundle\Controller;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Date;
use Contao\FrontendUser;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Template;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Respinar\ContaoJobsBundle\Model\JobsModel;
use Respinar\ContaoJobsBundle\Model\JobsCategoryModel;

/**
 * Class JobsModuleController
 *
 * @FrontendModule(JobsModuleController::TYPE)
 */
class JobsModuleController
{
    public function parseJobs($objJobs, $job_template) {

        $limit = $objJobs->count();

		if ($limit < 1)
		{
			return array();
		}

		$count = 0;
		$arrJobs = array();

		while ($objJobs->next())
		{
			$arrJobs[] = $this->parseJob($objJobs, $job_template, $count);
		}

		return $arrJobs;

    }

    public function parseJob($objJob, $job_template, $intCount=0)
    {

        $objTemplate = new FrontendTemplate($job_template);

		$objTemplate->setData($objJob->row());	

		return $objTemplate->parse();

    }
}
