import './bootstrap';
import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('yearSelected', event => {
        console.log('Calendar1:', event.calendar1);
        console.log('Calendar2:', event.calendar2);
    });
});

// datepicker
document.addEventListener('DOMContentLoaded', function () {
    const startDatePicker = flatpickr("#start-date", {
        dateFormat: "d-m-Y",
        allowInput: true,
        onChange: function(selectedDates, dateStr, instance) {
            endDatePicker.set('minDate', dateStr);

            const endDateInput = document.getElementById("end-date");
            const endDateValue = endDateInput.value;
            if (endDateValue && new Date(dateStr.split('-').reverse().join('-')) > new Date(endDateValue.split('-').reverse().join('-'))) {
                endDateInput.value = dateStr;
                endDatePicker.setDate(dateStr);
            }
        }
    });

    const endDatePicker = flatpickr("#end-date", {
        dateFormat: "d-m-Y",
        allowInput: true,
        onOpen: function(selectedDates, dateStr, instance) {
            const startDateInput = document.getElementById("start-date").value;
            if (startDateInput) {
                instance.set('minDate', startDateInput);
            }
        },
        onChange: function(selectedDates, dateStr, instance) {
            const startDateValue = document.getElementById("start-date").value;
            if (startDateValue && new Date(dateStr.split('-').reverse().join('-')) < new Date(startDateValue.split('-').reverse().join('-'))) {
                instance.setDate(startDateValue);
            }
        }
    });
});