

$(document).ready(function () {
   
    var now = new Date();
    var millisecond200day = 17280000000;
    var past200day = new Date(now.getTime() - millisecond200day);
    // DATA SELECTER
    if (checkExist($('.rangeDate'))) {
        $('.rangeDate').daterangepicker({
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "singleDatePicker": true,
            "autoApply": true,
            "minDate": past200day,
            "maxDate": now,
            "locale": {
                "format": "YYYY/MM/DD HH:mm:ss",
                "separator": " - ",
                "applyLabel": "USE",
                "cancelLabel": "CANCEL",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "daysOfWeek": ["S", "M", "T", "W", "R", "F", "S"],
                "monthNames": ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                "firstDay": 1
            }
        }, function (start, end, label) {
            // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });
    }

    if (checkExist($('.singleDate'))) {
        $('.singleDate').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "minDate": past200day,
            "maxDate": now,
            "locale": {
                "format": "YYYY/MM/DD",
                "separator": " ~ ",
                "applyLabel": "USE",
                "cancelLabel": "CANCEL",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "daysOfWeek": ["S", "M", "T", "W", "R", "F", "S"],
                "monthNames": ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                "firstDay": 1
            }
        }, function (start, end, label) {
            // console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });
    }
});
