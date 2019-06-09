app.factory('Utils', [function () {

    var init_year = 2017;

    return {
        GetCurrentYear: function () {
            var currentdate = new Date();
            return currentdate.getFullYear();
        },
        ArrayRange: function (start, end) {
            var foo = [];
            for (var i = start; i <= end; i++) {
                foo.push(i);
            }
            return foo;
        },
        GetYears: function (initial_year, end_year) {
            if (typeof initial_year === 'undefined') {
                initial_year = init_year;
            }
            if (typeof end_year === 'undefined') {
                end_year = this.GetCurrentYear();
            }
            console.dir([initial_year, end_year]);
            return this.ArrayRange(initial_year, end_year);
        },
        ParseMinutesToHoursFormat: function(minutes){
            var h = Math.floor(minutes / 60);
            var m = minutes % 60;
            h = h < 10 ? '0' + h : h;
            m = m < 10 ? '0' + m : m;

            return h + ':' + m;
        }
    };
}]);
