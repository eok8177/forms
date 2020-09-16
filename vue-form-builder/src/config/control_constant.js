// icon
import {faEdit} from '@fortawesome/free-solid-svg-icons/faEdit';
import {faCalculator} from '@fortawesome/free-solid-svg-icons/faCalculator';
import {faCalendarAlt} from '@fortawesome/free-solid-svg-icons/faCalendarAlt';
import {faClock} from '@fortawesome/free-solid-svg-icons/faClock';
import {faCheck} from '@fortawesome/free-solid-svg-icons/faCheck';
import {faDatabase} from '@fortawesome/free-solid-svg-icons/faDatabase';

// TEMPLATE Control
import TEMPLATETextControl from 'sethFormBuilder/template/ui/common/controls/TextControl';
import TEMPLATENumberControl from 'sethFormBuilder/template/ui/common/controls/NumberControl';
import TEMPLATECheckboxControl from 'sethFormBuilder/template/ui/common/controls/CheckboxControl';
import TEMPLATEDatePickerControl from 'sethFormBuilder/template/ui/common/controls/DatePickerControl';
import TEMPLATETimePickerControl from 'sethFormBuilder/template/ui/common/controls/TimePickerControl';
import TEMPLATESelectControl from 'sethFormBuilder/template/ui/common/controls/SelectControl';
import TEMPLATEFileControl from 'sethFormBuilder/template/ui/common/controls/FileControl';
import TEMPLATEHtmlControl from 'sethFormBuilder/template/ui/common/controls/HtmlControl';
import TEMPLATEAddressControl from 'sethFormBuilder/template/ui/common/controls/AddressControl';
import TEMPLATERadioControl from 'sethFormBuilder/template/ui/common/controls/RadioControl';
import TEMPLATEAllFieldsControl from 'sethFormBuilder/template/ui/common/controls/AllFieldsControl';

// CONFIG CONTROL
import SIDEBARDatePickerControl from 'sethFormBuilder/template/ui/sidebar_items/DatePickerConfigComponent';
import SIDEBARTimePickerControl from 'sethFormBuilder/template/ui/sidebar_items/TimePickerConfigComponent';
import SIDEBARSelectControl from 'sethFormBuilder/template/ui/sidebar_items/SelectConfigComponent';
import SIDEBARNumberControl from 'sethFormBuilder/template/ui/sidebar_items/NumberConfigComponent';
import SIDEBARTextControl from 'sethFormBuilder/template/ui/sidebar_items/TextConfigComponent';
import SIDEBARCheckboxControl from 'sethFormBuilder/template/ui/sidebar_items/CheckboxConfigComponent';
import SIDEBARFileControl from 'sethFormBuilder/template/ui/sidebar_items/FileConfigComponent';
import SIDEBARHtmlControl from 'sethFormBuilder/template/ui/sidebar_items/HtmlConfigComponent';
import SIDEBARAddressControl from 'sethFormBuilder/template/ui/sidebar_items/AddressConfigComponent';
import SIDEBARRadioControl from 'sethFormBuilder/template/ui/sidebar_items/RadioConfigComponent';
import SIDEBARAllFieldsControl from 'sethFormBuilder/template/ui/sidebar_items/AllFieldsConfigComponent';

// Template Control
// special key for control:
// other_properties: {
//     x: "zzz",
//     c: "xxx",
//     ...
// },
// validation_func: function() {
//  // validation function here
// }
//
const CONTROL_TYPES = {
    text: {
        label:"Text Input",
        icon: faEdit,
        source: {
            template: TEMPLATETextControl,
            config: SIDEBARTextControl
        }
    },
    number: {
        label:"Number Input",
        icon: faCalculator,
        source: {
            template: TEMPLATENumberControl,
            config: SIDEBARNumberControl
        }
    },
    datepicker: {
        label: "Date Picker",
        icon: faCalendarAlt,
        source: {
            template: TEMPLATEDatePickerControl,
            config: SIDEBARDatePickerControl,
        }
    },
    timepicker: {
        label:"Time Picker",
        icon: faClock,
        source: {
            template: TEMPLATETimePickerControl,
            config: SIDEBARTimePickerControl,
        }
    },
    select: {
        label: "Select Option",
        icon: faDatabase,
        source: {
            template: TEMPLATESelectControl,
            config: SIDEBARSelectControl
        }
    },
    checkbox: {
        label:"Checkbox",
        icon: faCheck,
        source: {
            template: TEMPLATECheckboxControl,
            config: SIDEBARCheckboxControl
        }
    },
    file: {
        label:"File Input",
        icon: faEdit,
        source: {
            template: TEMPLATEFileControl,
            config: SIDEBARFileControl
        }
    },
    html: {
        label:"HTML Block",
        icon: faEdit,
        source: {
            template: TEMPLATEHtmlControl,
            config: SIDEBARHtmlControl
        }
    },
    address: {
        label:"Address Block",
        icon: faEdit,
        source: {
            template: TEMPLATEAddressControl,
            config: SIDEBARAddressControl
        }
    },
    radio: {
        label: "Radio Buttons",
        icon: faDatabase,
        source: {
            template: TEMPLATERadioControl,
            config: SIDEBARRadioControl
        }
    },
    all_fields: {
        label: "All Fields",
        icon: faCheck,
        source: {
            template: TEMPLATEAllFieldsControl,
            config: SIDEBARAllFieldsControl
        }
    },
};

export {
    CONTROL_TYPES
}
