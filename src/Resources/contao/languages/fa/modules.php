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
 * Backend modules
 */
$GLOBALS['TL_LANG']['MOD']['jobs_modules'] = 'Jobs';
$GLOBALS['TL_LANG']['MOD']['jobs_list'] = ['Job Positions', 'Manage available Jobs'];


/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['jobs_modules'] = 'Jobs';
$GLOBALS['TL_LANG']['FMD'][JobsListingModuleController::TYPE] = ['Jobs List', 'Show available jobs as a list'];
$GLOBALS['TL_LANG']['FMD'][JobsDetailModuleController::TYPE] = ['Job Detail', 'Show Detail of job'];

