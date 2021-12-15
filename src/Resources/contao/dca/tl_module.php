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

use Respinar\ContaoJobsBundle\Controller\FrontendModule\JobsListingModuleController;
use Respinar\ContaoJobsBundle\Controller\FrontendModule\JobsDetailModuleController;


/**
 * Frontend modules
 */
$GLOBALS['TL_DCA']['tl_module']['palettes'][JobsListingModuleController::TYPE] = '{title_legend},name,headline,type;{category_legend},jobs_categories;{template_legend:hide},jobs_sortBy,imgSize,jobs_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes'][JobsDetailModuleController::TYPE]  = '{title_legend},name,headline,type;{category_legend},jobs_categories;{template_legend:hide},jobs_template,customTpl,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['jobs_categories'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['jobs_categories'],
	'exclude'              => true,
	'inputType'            => 'checkbox',
	'foreignKey'           => 'tl_jobs_category.title',
	'eval'                 => array('multiple'=>true, 'mandatory'=>true),
	'sql'				   => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['jobs_sortBy'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jobs_sortBy'],
	'default'                 => 'custom',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('custom','date_desc', 'date_asc','title_asc', 'title_desc'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(16) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['jobs_template'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['jobs_template'],
	'exclude'              => true,
	'inputType'            => 'select',
	'options_callback'     => array('tl_module_jobs', 'getJobsTemplates'),
	'eval'				   => array('tl_class'=>'w50 clr'),
	'sql'				   => "varchar(64) NOT NULL default ''",
);


/**
 * Class tl_module_jobs
 */
class tl_module_jobs extends Backend
{
	/**
	 * Return all Jobs templates as array
	 *
	 * @return array
	 */
	public function getJobsTemplates()
	{
		return $this->getTemplateGroup('jobs_');
	}
}