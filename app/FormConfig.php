<?php

namespace App;

use Illuminate\Support\Carbon;

trait FormConfig
{
    public function parseAppConfig($config)
    {
        $fields = [];
        $emails = [];

        $config = json_decode($config, true);

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
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$idInst.'_'.$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
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
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $fields[$control['fieldName']][$control['label'.$i]] = $control['value'.$i];
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
                                        "section" => $section['name'],
                                    ];
                                }
                            } else {

                                $fields[$control['fieldName']] = [
                                    "fieldName" => $control['fieldName'],
                                    "label" => $control['label'],
                                    "alias" => array_key_exists('alias', $control) ? $control['alias'] : ($control['label'] ? $control['label'] : $control['fieldName']),
                                    "control_type" => $control['type'],
                                    "section" => $section['name'],
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

    // for API when submit form
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

                                $fieldID = strval(preg_replace("/[^0-9]/", '', $control['fieldName']));

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


    // update alias value in Form config (json) from admin/form/settings
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

}