/**
* Description:
* Constants: control types
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/

// Control
import CheckboxControl from '../controls/CheckboxControl';
import DatePickerControl from '../controls/DatePickerControl';
import NumberControl from '../controls/NumberControl';
import SelectControl from '../controls/SelectControl';
import TextControl from '../controls/TextControl';
import TimePickerControl from '../controls/TimePickerControl';
import FileControl from '../controls/FileControl';
import HtmlControl from '../controls/HtmlControl';
import AddressControl from '../controls/AddressControl';
import RadioControl from '../controls/RadioControl';
import AllFieldsControl from '../controls/AllFieldsControl';

const CONTROL_TYPES = {
    text: {
        label:"Text Input",
        source: TextControl
    },
    number: {
        label:"Number Input",
        source: NumberControl
    },
    datepicker: {
        label: "Date Picker",
        source: DatePickerControl
    },
    timepicker: {
        label:"Time Picker",
        source: TimePickerControl
    },
    select: {
        label: "Select Option",
        source: SelectControl
    },
    checkbox: {
        label:"Checkbox",
        source: CheckboxControl
    },
    file: {
        label:"File Input",
        source: FileControl
    },
    html: {
        label:"HTML Block",
        source: HtmlControl
    },
    address: {
        label:"Address Block",
        source: AddressControl
    },
    radio: {
        label:"Radio Block",
        source: RadioControl
    },
    all_fields: {
        label:"All Fields",
        source: AllFieldsControl
    },
};

export {
    CONTROL_TYPES
}
