const moodChangerFunc = (changedToMode) => {
    if (changedToMode === 'N') {
        $('.moodChanger').attr('mode', 'D');
        $('#modeIcon').attr('class', 'fas fa-sun');
        $('body').addClass('dark-mode');
    } else {
        $('.moodChanger').attr('mode', 'N');
        $('#modeIcon').attr('class', 'fas fa-moon');
        $('body').removeClass('dark-mode');
    }
}
$('.moodChanger').click(function () {
    const changedToMode = $(this).attr('mode');
    localStorage.setItem('theme-mode', changedToMode);
    moodChangerFunc(changedToMode);
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
$('#color_code').on('keyup', function () {
    const colorCode = $(this).val();
    $('#showColorCode').css('background', colorCode);
});

function previewImage(input) {
    const container = document.getElementsByClassName('preview-container')[0];
    const viewer = document.getElementById('image-viewer');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            viewer.src = e.target.result;
            container.style.display = 'block'; // Make the container visible
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        // Hide the element if the user clears out their selection
        viewer.src = '#';
        container.style.display = 'none';
    }
}

$(function () {
    const changedToMode = localStorage.getItem('theme-mode');
    moodChangerFunc(changedToMode);

});


