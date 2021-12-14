<?php

/*
 * This file is part of Jobs Bundle.
 * 
 * (c) Hamid Abbaszadeh 2021 <abbaszadeh.h@gmail.com>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/respinar/contao-jobs-bundle
 */

use Respinar\ContaoJobsBundle\Model\JobsModel;
use Respinar\ContaoJobsBundle\Model\JobsCategoryModel;


/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['jobs_modules']['jobs_list'] = array(
    'tables' => array('tl_jobs_category','tl_jobs')
);

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_jobs'] = JobsModel::class;
$GLOBALS['TL_MODELS']['tl_jobs_category'] = JobsCategoryModel::class;
