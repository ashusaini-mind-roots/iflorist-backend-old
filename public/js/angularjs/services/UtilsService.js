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
        GetYears: function (initial_year) {
            if (typeof initial_year === 'undefined') {
                initial_year = init_year;
            }
            return this.ArrayRange(initial_year, this.GetCurrentYear());
        }
    };
}]);
