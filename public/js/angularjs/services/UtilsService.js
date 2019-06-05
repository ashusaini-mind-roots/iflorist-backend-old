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
        GetYears: function () {
            return this.ArrayRange(init_year, this.GetCurrentYear());
        }
    };
}]);
