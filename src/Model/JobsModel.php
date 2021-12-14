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

namespace Respinar\ContaoJobsBundle\Model;

use Contao\Model;

/**
 * Class JobsModel
 *
 * @package Respinar\ContaoJobsBundle\Model
 */
class JobsModel extends Model
{
    protected static $strTable = 'tl_jobs';

}

