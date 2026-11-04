$('.moodChanger').click(function () {
    const changedToMode = $(this).attr('mode');
    if (changedToMode === 'N') {
        $(this).attr('mode', 'D');
        $('#modeIcon').attr('class', 'fas fa-sun');
        $('body').addClass('dark-mode');
    } else {
        $(this).attr('mode', 'N');
        $('#modeIcon').attr('class', 'fas fa-moon');
        $('body').removeClass('dark-mode');
    }
});
$('.selectAll').change(function () {
    const getModule = $(this).data('slug');
    const getMode = $(this).data('mode');
    const isChecked = $(this).prop('checked');
    // console.log(getModule, getMode)
    $('.permissionCheckboxes').each(function () {

        // console.log(whichBoxs);
        if (getMode === 'A') {
            $(this).prop('checked', isChecked);
        } else {
            $('#grrp_all').prop('checked', false);
            let whichBoxs = $(this).data('slug');
            if (whichBoxs == getModule) {
                $(this).prop('checked', isChecked);
            }
        }
    });


});
$('.showHidePass').click(function () {
    const thisId = $(this).attr('id');
    const changeIn = $(this).data('fld');

    if ($('#' + changeIn).attr('type') == 'text') {
        $('#' + changeIn).attr('type', 'password');
        $('.' + thisId).removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        $('#' + changeIn).attr('type', 'text');
        $('.' + thisId).removeClass('fa-eye').addClass('fa-eye-slash');
    }
});

