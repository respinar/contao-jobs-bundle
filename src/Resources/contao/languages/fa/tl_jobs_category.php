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

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_jobs_category']['title_legend'] = "Title settings";
$GLOBALS['TL_LANG']['tl_jobs_category']['protected_legend'] = "Access protection";


/**
 * Operations
 */
$GLOBALS['TL_LANG']['tl_jobs_category']['edit'] = ["Datensatz mit ID: %s bearbeiten", "Datensatz mit ID: %s bearbeiten"];
$GLOBALS['TL_LANG']['tl_jobs_category']['copy'] = ["Datensatz mit ID: %s kopieren", "Datensatz mit ID: %s kopieren"];
$GLOBALS['TL_LANG']['tl_jobs_category']['delete'] = ["Datensatz mit ID: %s löschen", "Datensatz mit ID: %s löschen"];
$GLOBALS['TL_LANG']['tl_jobs_category']['show'] = ["Datensatz mit ID: %s ansehen", "Datensatz mit ID: %s ansehen"];

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_jobs_category']['title'] = ["Title", "Please enter a Jobs category title."];
$GLOBALS['TL_LANG']['tl_jobs_category']['jumpTo'] = ["Redirect page", "Please choose the job reader page to which visitors will be redirected when clicking a job item."];
$GLOBALS['TL_LANG']['tl_jobs_category']['protected'] = ["Protect category", "Show job items to certain member groups only."];
$GLOBALS['TL_LANG']['tl_jobs_category']['groups'] = ["Allowed member groups", "These groups will be able to see the job items in this category."];