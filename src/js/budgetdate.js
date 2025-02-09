import { Datepicker } from 'flowbite';

// set the target element of the input field
const $fromDate = document.getElementById('from-date');

const today = new Date().toLocaleDateString('en-US', {
  month: '2-digit',
  day: '2-digit',
  year: 'numeric'
});

// optional options with default values and callback functions
const options = {
    defaultDatepickerId: null,
    autohide: false,
    format: 'mm/dd/yyyy',
    maxDate: '02/10/2025',
    minDate: null,
    orientation: 'bottom',
    buttons: false,
    autoSelectToday: false,
    title: null,
    rangePicker: false,
    onShow: () => {},
    onHide: () => {},
};

const instanceOptions = {
  id: 'from-date',
  override: true
};

/*
 * $datepickerEl: required
 * options: optional
 */
const datepicker = new Datepicker($datepickerEl, options, instanceOptions);
