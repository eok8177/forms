<?php

namespace App;

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
                                } else {
                                    $fields[$idInst.'_'.$control['fieldName']]['label'] = $control['label'];
                                    $fields[$idInst.'_'.$control['fieldName']]['value'] = $control['value'];
                                }
                            }
                        }

                    }
                } else {
                    foreach ($section['rows'] as $row) {
                        if (array_key_exists('controls', $row)) {
                            foreach ($row['controls'] as $control) {

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
        $groups = [];
        $fields = [];

        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section)) {
                foreach ($section['rows'] as $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $control) {
                            if ($control['type'] == 'address') {
                                for ($i=1; $i <= 5; $i++) {
                                    $groups[$section['label']][$control['fieldName'].$i] = $control['label'.$i];
                                    $fields[$control['fieldName'].'_'.$i] = [
                                        "label" => $control['label'.$i],
                                        "control_type" => $control['type'],
                                    ];
                                }
                            } else {
                                $groups[$section['label']][$control['fieldName']] = $control['label'];
                                $fields[$control['fieldName']] = [
                                    "label" => $control['label'],
                                    "control_type" => $control['type'],
                                ];
                            }
                        }
                    }
                }

            }
        }

        return [
            'fields' => $fields,
            'groups' => $groups
        ];
    }


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

                                $fieldID = strval(preg_replace("/[^0-9]/", '', $control['fieldName']));

                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $data[$instanceID][$fieldID.$i] = $control['value'.$i];
                                        }
                                    }
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

                                $fieldID = strval(preg_replace("/[^0-9]/", '', $control['fieldName']));

                                if ($control['type'] == 'address') {
                                    for ($i=1; $i <= 5; $i++) {
                                        if ($control['show'.$i] && @$control['value'.$i]) {
                                            $data[$fieldID.$i] = $control['value'.$i];
                                        }
                                    }
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

}