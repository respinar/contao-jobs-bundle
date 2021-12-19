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

use Contao\Backend;
use Contao\DC_Table;
use Contao\Input;
use Contao\System;

/**
 * Table tl_jobs_request
 */
$GLOBALS['TL_DCA']['tl_jobs_request'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',        
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
                'id' => 'primary'
            )
        ),
    ),
    'edit'        => array(
        'buttons_callback' => array(
            array('tl_jobs_request', 'buttonsCallback')
        )
    ),
    'list'        => array(
        'sorting'           => array(
            'mode'        => 2,
            'fields'      => array('name'),
            'flag'        => 1,
            'panelLayout' => 'filter;sort,search,limit'
        ),
        'label'             => array(
            'fields' => array('name'),
            'format' => '%s',
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_jobs_request']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_jobs_request']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_jobs_request']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'   => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_jobs_request']['show'],
                'href'       => 'act=show',
                'icon'       => 'show.gif',
                'attributes' => 'style="margin-right:3px"'
            ),
        )
    ),
    // Palettes
    'palettes'    => array(
        'default'      => '{title_legend},name,phone;{general_legend},gender,experience,salary;'
    ),    
    // Fields
    'fields'      => array(
        'id'             => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'         => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'name'          => array(
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),        
        'phone' => array
		(
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('doNotCopy'=>true, 'unique'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) BINARY NOT NULL default ''"
		),
        'position'          => array(
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ), 
        'time'          => array(
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),   
        'gender'    => array(
            'inputType' => 'select',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'reference' => $GLOBALS['TL_LANG']['tl_jobs_request'],
            'options'   => array('male', 'female'),
            //'foreignKey'            => 'tl_user.name',
            //'options_callback'      => array('CLASS', 'METHOD'),
            'eval'      => array('includeBlankOption' => true, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
            //'relation'  => array('type' => 'hasOne', 'load' => 'lazy')
        ),
        'experience' => array(
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'eval'      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'salary' => array(
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'eval'      => array('maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''"
        )
    )
);

/**
 * Class tl_jobs_request
 */
class tl_jobs_request extends Backend
{
    /**
     * @param $arrButtons
     * @param  DC_Table $dc
     * @return mixed
     */
    public function buttonsCallback($arrButtons, DC_Table $dc)
    {
        if (Input::get('act') === 'edit')
        {
            $arrButtons['customButton'] = '<button type="submit" name="customButton" id="customButton" class="tl_submit customButton" accesskey="x">' . $GLOBALS['TL_LANG']['tl_jobs_request']['customButton'] . '</button>';
        }

        return $arrButtons;
    }

}
