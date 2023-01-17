$(document).ready(() => {
    let $forms = $('.form');

    $forms.each((ix, el) => {
        let $swap = $('.form-swap', $(el));

        $swap.on('click', () => {
            $forms.show();
            $(el).hide();
        });
    });
});