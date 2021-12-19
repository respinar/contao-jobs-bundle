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

namespace Respinar\ContaoJobsBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Date;
use Contao\FrontendUser;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Template;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Respinar\ContaoJobsBundle\Model\JobsModel;
use Respinar\ContaoJobsBundle\Model\JobsCategoryModel;
use Respinar\ContaoJobsBundle\Controller\JobsController;

/**
 * Class JobsListingModuleController
 *
 * @FrontendModule(JobsListingModuleController::TYPE, category="jobs_modules", template="mod_jobs_listing_module")
 */
class JobsListingModuleController extends AbstractFrontendModuleController
{
    public const TYPE = 'jobs_listing_module';

    /**
     * @var PageModel
     */
    protected $page;

    /**
     * This method extends the parent __invoke method,
     * its usage is usually not necessary
     */
    public function __invoke(Request $request, ModuleModel $model, string $section, array $classes = null, PageModel $page = null): Response
    {
        // Get the page model
        $this->page = $page;

        if ($this->page instanceof PageModel && $this->get('contao.routing.scope_matcher')->isFrontendRequest($request))
        {
            // If TL_MODE === 'FE'
            $this->page->loadDetails();
        }

        return parent::__invoke($request, $model, $section, $classes);
    }

    /**
     * Lazyload some services
     */
    public static function getSubscribedServices(): array
    {
        $services = parent::getSubscribedServices();

        $services['contao.framework'] = ContaoFramework::class;
        $services['database_connection'] = Connection::class;
        $services['contao.routing.scope_matcher'] = ScopeMatcher::class;
        $services['security.helper'] = Security::class;
        $services['translator'] = TranslatorInterface::class;

        return $services;
    }

    /**
     * Generate the module
     */
    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {

        $jobs_categories = StringUtil::deserialize($model->jobs_categories);

		$intTotal = JobsModel::countPublishedByPids($jobs_categories);

        $arrOptions['order'] = 'id';

        $objJobs = JobsModel::findPublishedByPids($jobs_categories,0,0,$arrOptions);
        
        // No items found
		if ($objJobs !== null)
		{
			$template->jobs = JobsController::parseJobs($objJobs,$model->jobs_template);
		}        

        return $template->getResponse();
    }

}
