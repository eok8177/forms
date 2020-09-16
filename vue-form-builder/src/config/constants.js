import {faEdit} from '@fortawesome/free-solid-svg-icons/faEdit';
import {faCalculator} from '@fortawesome/free-solid-svg-icons/faCalculator';
import {faCalendarAlt} from '@fortawesome/free-solid-svg-icons/faCalendarAlt';
import {faClock} from '@fortawesome/free-solid-svg-icons/faClock';
import {faCheck} from '@fortawesome/free-solid-svg-icons/faCheck';
import {faDatabase} from '@fortawesome/free-solid-svg-icons/faDatabase';

var FORM_CONSTANTS = {};
var CONTROL_CONSTANTS = {};

FORM_CONSTANTS.SectionLayout = {
  collapse: "Collapse",
  tab: "Tab",
  // inner: "Inner Parent",
};

FORM_CONSTANTS.Section = {
    name: "",
    label: "",
    clientKey: "",
    order: 0,
    rows: [],

    // config
    labelPosition: "left", // left or top

    // for dynamic
    isDynamic: false,
    minInstance: 1,
    maxInstance: 0, //0 for unlimited
    instances: [], // for save data in GUI to easily to retrieve @@
    expandedAdmin: true,
    expanded: false,
};

FORM_CONSTANTS.Row = {
    name: "",
    label: "",
    order: 0,
    controls: [],
};

FORM_CONSTANTS.Control = {
    type: "",
    name: "",
    fieldName: "",
    label: "",
    order: 0,
    defaultValue: "",
    value: "",
    className: 'col-md-4',
    readonly: false,
    description: "",

    // label style
    labelBold: false,
    labelItalic: false,
    labelUnderline: false,

    // validation
    required: false,

    // attr for text
    isMultiLine: false,

    // attr for number
    isInteger: false,
    decimalPlace: 0,

    // attr for datePicker
    isTodayValue: false,
    dateFormat: "dd/mm/yyyy",

    // attr for timePicker
    isNowTimeValue: false,
    timeFormat: "HH:mm", // enhancement later

    // attr for select
    isMultiple: false,
    isAjax: false, // is ajax data source or not
    dataOptions: [], // static data source
    ajaxDataUrl: "", // ajax data source

    // attr for checkbox
    isChecked: false,

    hidden: false, // hidden field
    text: '', // HTML Block
    cssClass: '', // custom CSS Class

    isCalculated: false // is isCalculated data or not
};

FORM_CONSTANTS.Type = {
    text: {
        label:"Text Input",
        icon: faEdit
    },
    number: {
        label:"Number Input",
        icon: faCalculator
    },
    datepicker: {
        label: "Date Picker",
        icon: faCalendarAlt
    },
    timepicker: {
        label:"Time Picker",
        icon: faClock
    },
    select: {
        label: "Select Option",
        icon: faDatabase
    },
    checkbox: {
        label:"Checkbox",
        icon: faCheck
    },
    file: {
        label:"File Input",
        icon: faEdit
    },
    html: {
        label:"HTML Block",
        icon: faEdit
    },
    address: {
        label:"Address Block",
        icon: faEdit
    },
    radio: {
        label: "Radio Buttons",
        icon: faDatabase
    },
    all_fields: {
        label: "All Fields",
        icon: faCheck
    },
};

FORM_CONSTANTS.WidthOptions = {
    "col-md-1": "Width 1 parts",
    "col-md-2": "Width 2 parts",
    "col-md-3": "Width 3 parts",
    "col-md-4": "Width 4 parts",
    "col-md-5": "Width 5 parts",
    "col-md-6": "Width 6 parts",
    "col-md-7": "Width 7 parts",
    "col-md-8": "Width 8 parts",
    "col-md-9": "Width 9 parts",
    "col-md-10": "Width 10 parts",
    "col-md-11": "Width 11 parts",
    "col-md-12": "Width 12 parts",
};

FORM_CONSTANTS.OptionDefault = {
    id: "",
    text: ""
};

CONTROL_CONSTANTS.DateFormat = {
    // rule: date picker format => moment format
    'dd/mm/yyyy': "D/M/YYYY",
    'dd-mm-yyyy': "D-M-YYYY",
    'mm/dd/yyyy': "M/D/YYYY",
    'mm-dd-yyyy': "M/D/YYYY",
    'yyyy/mm/dd': "YYYY/M/D",
    'yyyy-mm-dd': "YYYY-M-D",
};

CONTROL_CONSTANTS.TimeFormat = {
    'H:m': 'H:m',
    'HH:mm': 'HH:mm',
    'h:m p': "h:m A",
    'hh:mm p': "hh:mm A"
};

export {
    FORM_CONSTANTS,
    CONTROL_CONSTANTS
}
