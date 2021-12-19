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
use Contao\Config;
use Contao\StringUtil;
use Contao\FrontendUser;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Template;
use Contao\FrontendTemplate;
use Contao\System;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Respinar\ContaoJobsBundle\Model\JobsModel;
use Respinar\ContaoJobsBundle\Model\JobsCategoryModel;

//System::loadLanguageFile('tl_jobs');

/**
 * Class JobsController
 */
class JobsController
{


	/**
	 * URL cache array
	 * @var array
	 */
	private static $arrUrlCache = array();


    public static function parseJobs($objJobs, $job_template) {

        $limit = $objJobs->count();

		if ($limit < 1)
		{
			return array();
		}

		$count = 0;
		$arrJobs = array();

		while ($objJobs->next())
		{
			$arrJobs[] = self::parseJob($objJobs, $job_template, $count);
		}

		return $arrJobs;

    }

    public static function parseJob($objJob, $job_template, $intCount=0)
    {

        $objTemplate = new FrontendTemplate($job_template);

		$objTemplate->setData($objJob->row());

		$objTemplate->link = self::generateLink($GLOBALS['TL_LANG']['MSC']['job_detail'],$objJob, $blnAddArchive);

		$objTemplate->gender = $GLOBALS['TL_LANG']['tl_jobs'][$objJob->gender];
		$objTemplate->type = $GLOBALS['TL_LANG']['tl_jobs'][$objJob->type];

		$objTemplate->txt_gender = $GLOBALS['TL_LANG']['MSC']['job_gender'];
		$objTemplate->txt_type = $GLOBALS['TL_LANG']['MSC']['job_type'];
		$objTemplate->txt_experience = $GLOBALS['TL_LANG']['MSC']['job_experience'];
		$objTemplate->txt_salary = $GLOBALS['TL_LANG']['MSC']['job_salary'];
		$objTemplate->txt_place = $GLOBALS['TL_LANG']['MSC']['job_place'];
		$objTemplate->txt_department = $GLOBALS['TL_LANG']['MSC']['job_department'];
		$objTemplate->txt_qualification = $GLOBALS['TL_LANG']['MSC']['job_qualification'];
		$objTemplate->txt_duties = $GLOBALS['TL_LANG']['MSC']['job_duties'];
		$objTemplate->txt_condition = $GLOBALS['TL_LANG']['MSC']['job_condition'];	

		return $objTemplate->parse();

    }

	/**
	 * Generate a link and return it as string
	 *
	 * @param string    $strLink
	 * @param JobsModel $objJob
	 * @param boolean   $blnAddArchive	 
	 *
	 * @return string
	 */
	public static function generateLink($strLink, $objJob, $blnAddArchive=false)
	{		
		$strJobUrl = self::generateJobUrl($objJob, $blnAddArchive);

		return sprintf('<a href="%s" title="%s"%s>%s</a>', $strJobUrl, $objJob->title, ' rel="referrer opener"', $strLink);
	}

    /**
	 * Generate a URL and return it as string
	 *
	 * @param JobsModel $objItem
	 * @param boolean   $blnAddArchive
	 * @param boolean   $blnAbsolute
	 *
	 * @return string
	 */
	public static function generateJobUrl($objItem, $blnAddArchive=false, $blnAbsolute=false)
	{
		$strCacheKey = 'id_' . $objItem->id . ($blnAbsolute ? '_absolute' : '');

		// Load the URL from cache
		if (isset(self::$arrUrlCache[$strCacheKey]))
		{
			return self::$arrUrlCache[$strCacheKey];
		}

		// Initialize the cache
		self::$arrUrlCache[$strCacheKey] = null;		

		// Link to the default page
		if (self::$arrUrlCache[$strCacheKey] === null)
		{
			$objPage = PageModel::findByPk($objItem->getRelated('pid')->jumpTo);

			if (!$objPage instanceof PageModel)
			{
				self::$arrUrlCache[$strCacheKey] = StringUtil::ampersand(Environment::get('request'));
			}
			else
			{
				$params = (Config::get('useAutoItem') ? '/' : '/items/') . ($objItem->alias ?: $objItem->id);

				self::$arrUrlCache[$strCacheKey] = StringUtil::ampersand($blnAbsolute ? $objPage->getAbsoluteUrl($params) : $objPage->getFrontendUrl($params));
			}
			
		}

		return self::$arrUrlCache[$strCacheKey];
	}
}
