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

/**
 * Table tl_jobs_category
 */
$GLOBALS['TL_DCA']['tl_jobs_category'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'ctable'           => array('tl_jobs'),
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
                'id' => 'primary'
            )
        ),
    ),
    'edit'        => array(
        'buttons_callback' => array(
            array('tl_jobs_category', 'buttonsCallback')
        )
    ),
    'list'        => array(
        'sorting'           => array(
            'mode'        => 1,
            'fields'      => array('title'),
            'flag'        => 1,
            'panelLayout' => 'search,limit'
        ),
        'label'             => array(
            'fields' => array('title'),
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
            'edit' => array
			(
				'href'                => 'table=tl_jobs',
				'icon'                => 'edit.svg'
			),
			'editheader' => array
			(
				'href'                => 'act=edit',
				'icon'                => 'header.svg'
			),           
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_jobs_category']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_jobs_category']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'   => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_jobs_category']['show'],
                'href'       => 'act=show',
                'icon'       => 'show.gif',
                'attributes' => 'style="margin-right:3px"'
            ),
        )
    ),
    // Palettes
    'palettes'    => array(
        '__selector__' => array('protected'),
        'default'      => '{title_legend},title,jumpTo;{protected_legend:hide},protected;'
    ),
    // Subpalettes
    'subpalettes' => array(
        'protected' => 'groups',
    ),
    // Fields
    'fields'      => array(
        'id' => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array(
            'exclude'     => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'jumpTo' => array
		(
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_page.title',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "int(10) unsigned NOT NULL default 0",
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
		),
		'protected' => array
		(
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'groups' => array
		(
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('mandatory'=>true, 'multiple'=>true),
			'sql'                     => "blob NULL",
			'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
		)
    )
);

/**
 * Class tl_jobs_category
 */
class tl_jobs_category extends Backend
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
            $arrButtons['customButton'] = '<button type="submit" name="customButton" id="customButton" class="tl_submit customButton" accesskey="x">' . $GLOBALS['TL_LANG']['tl_jobs_category']['customButton'] . '</button>';
        }

        return $arrButtons;
    }
}
