app.factory('Spinner', Service);

function Service() {

    var public_members = {
        toggle: Toggle,
        switch_Style : SwitchStyle,
        isNotHidden_Loader: IsNotHidden_Loader,
        hide_Loader: Hide_Loader,
        show_Loader: Show_Loader,
        ishiddenLoader: true,
        shrinkOnHide: true,
    };

    return public_members;

    function Toggle() {
        public_members.ishiddenLoader = !public_members.ishiddenLoader;
       // console.log(public_members.ishiddenLoader);
    }

    function IsNotHidden_Loader() {
        return public_members.ishiddenLoader;
    }

    function Show_Loader() {
        return public_members.ishiddenLoader = !false;
    }
    function Hide_Loader() {
        return public_members.ishiddenLoader = !true;
    }
    function SwitchStyle() {
        public_members.shrinkOnHide = !public_members.shrinkOnHide;
    }
}