// Control
import CheckboxControl from '../controls/CheckboxControl';
import DatePickerControl from '../controls/DatePickerControl';
import NumberControl from '../controls/NumberControl';
import SelectControl from '../controls/SelectControl';
import TextControl from '../controls/TextControl';
import TimePickerControl from '../controls/TimePickerControl';

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
    }
};

export {
    CONTROL_TYPES
}
