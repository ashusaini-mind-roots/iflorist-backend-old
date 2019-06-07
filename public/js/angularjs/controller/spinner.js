app.controller('SpinnerController', function ($scope, Spinner) {
    console.log('spinner.js load success');

    $scope.hideLoader = Spinner.hideLoader;
    $scope.shrinkOnHide = Spinner.shrinkOnHide;
    $scope.isNotHidden_Loader = Spinner.isNotHidden_Loader;
});
