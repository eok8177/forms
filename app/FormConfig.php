<?php

/**
* Description:
* Form config trait (methods that can be used in a concrete class)
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - parseAppConfig($config) | parse application's config
* - parseFormConfig($config) | parse form's config
* - parseFormStaticSections($config)
* - parseApp($config) | parse application's details (for API when form is submitted)
* - updateConfigAlias($config, $alias) | update alias value in Form config (json) from admin/form/settings
* - parseDate($dateFormat , $value)
*/

namespace App;

use Illuminate\Support\Carbon;

trait FormConfig
{

    /**
    * Description:
    * parse application's config
    *
    * List of parameters:
    * - none
    *
    * Example of usage:
    * see method app/Application.getAdditionalFieldAttribute()
    */
    public function parseAppConfig($config)
    {
        $fields = [];
        $emails = [];

        $config = json_decode($config, true);

        if ($config)
        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section)) {

                if ($section['isDynamic']) {
                    foreach ($section['instances'] as $idInst => $instance) {
                        foreach ($instance as $section) {
                            foreach ($section['controls'] as $control) {
                                if ($control['type'] == 'html') continue;

                                $fields[$idInst.'_'.$control['fieldName']]['type'] = $control['type'];

                                if (array_key_exists('isEmail', $control) && $control['isEmail']) {
                                    $fields[$idInst.'_'.$control['fieldName']]['type'] = 'email';
                                    $emails[$control['label']] = $control['value'];
                                }
                                if ($control['type'] == 'address') {
                                    $fields[$idInst.'_'.$control['fieldName']]['value'] = '';
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$idInst.'_'.$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
                                            $fields[$idInst.'_'.$control['fieldName']]['value'] .= $control['value'.$i].'';
                                        }
                                    }
                                } elseif ($control['type'] == 'datepicker') {
                                    $fields[$idInst.'_'.$control['fieldName']]['label'] = @$control['label'];
                                    $fields[$idInst.'_'.$control['fieldName']]['value'] = $this->parseDate($control['dateFormat'] , $control['value']);
                                } else {
                                    $fields[$idInst.'_'.$control['fieldName']]['label'] = @$control['label'];
                                    $fields[$idInst.'_'.$control['fieldName']]['value'] = @$control['value'];
                                }
                            }
                        }

                    }
                } else {
                    foreach ($section['rows'] as $row) {
                        if (array_key_exists('controls', $row)) {
                            foreach ($row['controls'] as $control) {

                                if ($control['type'] == 'html') continue;

                                $fields[$control['fieldName']]['type'] = $control['type'];

                                if (array_key_exists('isEmail', $control) && $control['isEmail']) {
                                    $fields[$control['fieldName']]['type'] = 'email';
                                    $emails[$control['label']] = $control['value'];
                                }
                                if ($control['type'] == 'address') {
                                    $fields[$control['fieldName']]['value'] = '';
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
                                            $fields[$control['fieldName']]['value'] .= $control['value'.$i].' ';
                                        }
                                    }
                                    if (@$control['mapIt']) {
                                        @$fields[$control['fieldName']]['lat'] = $control['lat'];
                                        @$fields[$control['fieldName']]['lng'] = $control['lng'];
                                        @$fields[$control['fieldName']]['address'] = $control['address'];
                                    }
                                } elseif ($control['type'] == 'datepicker') {
                                    $fields[$control['fieldName']]['label'] = @$control['label'];
                                    $fields[$control['fieldName']]['value'] = $this->parseDate($control['dateFormat'] , $control['value']);
                                } else {
                                    $fields[$control['fieldName']]['label'] = $control['label'];
                                    $fields[$control['fieldName']]['value'] = @$control['value'];
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            'fields' => $fields,
            'emails' => $emails
        ];
    }


    /**
    * Description:
    * parse form's config
    *
    * List of parameters:
    * - none
    *
    * Example of usage:
    * see method app/Form.notUniqueAlias()
    */
    public function parseFormConfig($config)
    {
        $config = json_decode($config, true);
        $groups = []; // for macros: email & additional field
        $fields = []; // for API when form activated
        $full = []; // with groups & alias for admin/form/settings Alias show
        $alias = []; // parse alias for unque check

        if ($config)
        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section)) {
                foreach ($section['rows'] as $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $control) {
                            if ($control['type'] == 'html') continue;

                            if ($control['type'] == 'address') {
                                for ($i=1; $i <= 5; $i++) {

                                    $fields[$control['fieldName'].'_'.$i] = [
                                        "fieldName" => $control['fieldName'],
                                        "label" => $control['label'.$i],
                                        "alias" => array_key_exists('alias', $control) ? $control['alias'].$i : ($control['label'] ? $control['label'].$i : $control['fieldName'].$i),
                                        "control_type" => $control['type'],
                                        "section" => $section['label'],
                                    ];
                                }
                            } else {

                                $fields[$control['fieldName']] = [
                                    "fieldName" => $control['fieldName'],
                                    "label" => $control['label'],
                                    "alias" => array_key_exists('alias', $control) ? $control['alias'] : ($control['label'] ? $control['label'] : $control['fieldName']),
                                    "control_type" => $control['type'],
                                    "section" => $section['label'],
                                ];
                            }
                            $groups[$section['label']][$control['fieldName']] = $control['label'];
                            // address block has One alias
                            $full[$section['label']][$control['fieldName']] = [
                                "fieldName" => $control['fieldName'],
                                "label" => $control['label'] ? $control['label'] : $control['fieldName'],
                                "alias" => array_key_exists('alias', $control) ? $control['alias'] : $control['label'],
                                "control_type" => $control['type'],
                            ];
                            $alias[$control['fieldName']] = array_key_exists('alias', $control) ? $control['alias'] : ($control['label'] ? $control['label'] : $control['fieldName']);
                        }
                    }
                }

            }
        }

        return [
            'fields' => $fields,
            'groups' => $groups,
            'full' => $full,
            'alias' => $alias,
        ];
    }


    /**
    * Description:
    * parse form's config
    *
    * List of parameters:
    * - none
    *
    * Example of usage:
    * 
    */
    public function parseFormStaticSections($config)
    {
        $config = json_decode($config, true);
        $groups = []; // for macros: email & additional field

        if ($config)
        foreach ($config['sections'] as $section) {
            if ($section['isDynamic']) continue;
            if (array_key_exists('rows', $section)) {
                foreach ($section['rows'] as $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $control) {
                            if ($control['type'] == 'html') continue;
                            $groups[$section['label']][$control['fieldName']] = $control['label'];
                        }
                    }
                }
            }
        }

        return $groups;
    }


    /**
    * Description:
    * parse application's details (for API when form is submitted)
    *
    * List of parameters:
    * $config: string
    *
    * Example of usage:
    * see method app/Application.createEntry()
    */
    public function parseApp($config)
    {
        $data = [];

        $config = json_decode($config, true);

        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section)) {

                if ($section['isDynamic']) {
                    $sectionName = strval(preg_replace("/[^0-9]/", '', $section['name']));

                    foreach ($section['instances'] as $idInst => $instance) {
                        $instanceID = $sectionName.'_'.$idInst;

                        foreach ($instance as $sectionID => $section) {

                            foreach ($section['controls'] as $control) {
                                if ($control['type'] == 'html') continue;

                                // remove suffix starting with `_d0`
                                $controlFieldName = $control['fieldName'];
                                $_dSuffixPosition = strrpos($controlFieldName, '_d');
                                if($_dSuffixPosition !== false) {
                                    $controlFieldName = substr($controlFieldName, 0, $_dSuffixPosition);
                                }

                                $fieldID = strval(preg_replace("/[^0-9]/", '', $controlFieldName));

                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $data[$instanceID][$fieldID.$i] = $control['value'.$i];
                                        }
                                    }
                                } elseif ($control['type'] == 'datepicker') {
                                    $data[$instanceID][$fieldID] = $this->parseDate($control['dateFormat'] , $control['value']);
                                } else {
                                    if ($control['type'] != 'html') {
                                        $value = is_array($control['value']) ? null : $control['value'];
                                        $data[$instanceID][$fieldID] = $value;
                                    }
                                }
                            }

                        }

                    }
                } else { // not Dynamic fields

                    foreach ($section['rows'] as $row) {
                        if (array_key_exists('controls', $row)) {
                            foreach ($row['controls'] as $control) {
                                if ($control['type'] == 'html') continue;

                                $fieldID = strval(preg_replace("/[^0-9]/", '', $control['fieldName']));

                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $data[$fieldID.$i] = $control['value'.$i];
                                        }
                                    }
                                } elseif ($control['type'] == 'datepicker') {
                                    $data[$fieldID] = $this->parseDate($control['dateFormat'] , $control['value']);
                                } else {
                                    if ($control['type'] != 'html') {
                                        $value = is_array($control['value']) ? null : $control['value'];
                                        $data[$fieldID] = $value;
                                    }

                                }
                            }
                        }
                    }

                }
            }
        }

        return $data;
    }


    /**
    * Description:
    * update alias value in Form config (json) from admin/form/settings
    *
    * List of parameters:
    * - $config: string
    * - $alias : string
    *
    * Example of usage:
    *
    */ 
    public function updateConfigAlias($config, $alias)
    {
        $config = json_decode($config, true);

        foreach ($config['sections'] as $sectionID => $section) {
            if (array_key_exists('rows', $section)) {

                foreach ($section['rows'] as $rowID => $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $controlID => $control) {
                            $fieldID = $control['fieldName'];
                            if (array_key_exists($fieldID, $alias)) {
                                $config['sections'][$sectionID]['rows'][$rowID]['controls'][$controlID]['alias'] = $alias[$fieldID];
                            }
                        }
                    }
                }

            }
        }

        return json_encode($config);
    }

    private function parseDate($dateFormat , $value)
    {
        $dateFormat = str_replace('yyyy', 'Y', $dateFormat);
        $dateFormat = str_replace('yy', 'Y', $dateFormat);
        $dateFormat = str_replace('mm', 'm', $dateFormat);
        $dateFormat = str_replace('dd', 'd', $dateFormat);

        try {
            $dateValue = Carbon::createFromFormat($dateFormat, $value);
            $dateValue = $dateValue->format('Y-m-d');
        } catch (\Exception $e) {
            return '';
        }

        return $dateValue;
    }


    /**
    * Description:
    * parse names of files from application's config
    *
    * List of parameters:
    * - $config: string
    *
    * Return:
    * - $files: array
    *
    * Example of usage:
    * see method app/Application.checkFiles()
    */ 
    public function parseFiles($config)
    {
        $config = json_decode($config, true);
        $files = [];

        foreach ($config['sections'] as $sectionID => $section) {
            if (array_key_exists('rows', $section)) {

                foreach ($section['rows'] as $rowID => $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $controlID => $control) {
                            if ($control['type'] == 'file') {
                                $files[$control['fieldName']] = [
                                    'fieldName' => $control['fieldName'],
                                    'value' => $control['value'],
                                    'alias' => $control['alias'],
                                    'label' => $control['label'],
                                ];
                            }
                        }
                    }
                }

            }
        }

        return $files;
    }

}