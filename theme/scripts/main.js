$(document).ready(() => {
    let $forms = $('.form');

    $forms.each((ix, el) => {
        let $swap = $('.form-swap', $(el));

        $swap.on('click', () => {
            $forms.show();
            $(el).hide();
        });
    });

    let $filelist = $('.filelist');
    let $files = $('.file', $filelist);
    let $filterlist = $('.filterlist');
    let filetypes = [];

    $files.each((ix, el) => filetypes.push($(el).data('type')));

    filetypes = filetypes.filter((item, i, filetypes) => i == filetypes.indexOf(item));

    filetypes.forEach(el => $filterlist.append('<button class="filterfiles">' + el +'</button>'));

    $filterlist.append('<button class="filterfiles-clear">CLEAR</button>');

    let $filterfiles = $('.filterfiles');

    $filterfiles.each((ix, el) => {
        $(el).on('click', () => {
            $files.hide();
            $files.filter((ix, val) => $(val).data('type') == $(el).text()).show();
        });
    });

    $('.filterfiles-clear').on('click', () => $files.show());
});