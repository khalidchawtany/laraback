// default datatable settings
$.extend(true, $.fn.dataTable.defaults, {
    columnDefs: [
        {
            targets: 'actions',
            className: 'actions',
            searchable: false,
            sortable: false
        }
    ],
    lengthMenu: [5, 10, 25, 50, 100, 250, 500],
    pageLength: 25,
    language: {
        search: '',
        searchPlaceholder: 'Search'
    },
    processing: true,
    serverSide: true,
    stateSave: true,
    stateDuration: 0,
    responsive: true,
    stateSaveParams: function (settings, data) {
        data.search.search = '';
        data.start = 0;
    },
    stateSaveCallback: function (settings, data) {
        localStorage.setItem($(this).attr('id'), JSON.stringify(data));
    },
    stateLoadCallback: function () {
        return JSON.parse(localStorage.getItem($(this).attr('id')));
    },
    initComplete: function (settings, json) {
        var self = this.api();
        var filter_input = $('#' + settings.nTable.id + '_filter input').unbind();
        var search_button = $('<button type="button" class="btn btn-primary btn-sm btn-icon ml-1 mb-1" title="Search"><i class="fa fa-fw fa-search"></i></button>').click(function () {
            self.search(filter_input.val()).draw();
        });
        var reset_button = $('<button type="button" class="btn btn-secondary btn-sm btn-icon ml-1 mb-1" title="Reset"><i class="fa fa-fw fa-undo"></i></button>').click(function () {
            filter_input.val('');
            search_button.click();
        });

        $(document).keypress(function (event) {
            if (event.which === 13) {
                search_button.click();
            }
        });

        $('#' + settings.nTable.id + '_filter').append(search_button, reset_button);
    }
});

$(document).ready(function () {
    // toggle sidebar when button clicked
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });

    // auto-expand submenu if an item is active
    var active = $('.sidebar .active');

    if (active.length && active.parent('.collapse').length) {
        var parent = active.parent('.collapse');

        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }

    // flash success message if present
    var body = $('body');

    if (body.attr('data-flash-class')) {
        flash(body.attr('data-flash-class'), body.attr('data-flash-message'));
        body.removeAttr('data-flash-class').removeAttr('data-flash-message');
    }

    // perform on ajax complete
    $(document).ajaxComplete(function () {
        // re-enable form submits
        var submitted = $('.submitted');

        submitted.find(':submit').each(function () {
            $(this).html($(this).data('original-html'));
            $(this).removeAttr('data-original-html');
            $(this).css('width', 'auto');
        });
        submitted.removeClass('submitted');

        // show time in user timezone
        timezones();
    });

    // ajax form processing
    $(document).on('submit', 'form', function (event) {
        event.preventDefault();

        var form = $(this);

        if (!form.hasClass('submitted')) {
            // disable extra form submits
            form.addClass('submitted');
            form.find(':submit').each(function () {
                $(this).css('width', $(this).outerWidth());
                $(this).attr('data-original-html', $(this).html());
                $(this).html('<i class="fa fa-spinner fa-spin"></i>');
            });

            // remove existing alert & invalid field info
            $('.alert-fixed').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                contentType: false,
                processData: false,
                data: new FormData(form[0]),
                success: function (data) {
                    // perform redirect
                    if (data.hasOwnProperty('redirect')) {
                        $(location).attr('href', data.redirect);
                    }

                    // flash message using class
                    if (data.hasOwnProperty('flash')) {
                        flash(data.flash[0], data.flash[1]);
                    }

                    // dismiss modal
                    if (data.hasOwnProperty('dismiss_modal')) {
                        form.closest('.modal').modal('toggle');
                    }

                    // reload page
                    if (data.hasOwnProperty('reload_page')) {
                        location.reload();
                    }

                    // reload datatables
                    if (data.hasOwnProperty('reload_datatables')) {
                        $($.fn.dataTable.tables()).DataTable().ajax.reload();
                    }
                },
                error: function (data) {
                    var element;

                    // flash error message
                    flash('danger', data.responseJSON.message);

                    // show error for each element
                    if (data.responseJSON.hasOwnProperty('errors')) {
                        $.each(data.responseJSON.errors, function (key, value) {
                            element = $('#' + $.escapeSelector(key));
                            element.addClass('is-invalid');
                            element.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                        });
                    }
                }
            });
        }
    });

    // remove invalid highlight on input
    $(document).on('keyup change', '.is-invalid', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });

    // show ajax modal with content
    $(document).on('click', '[data-modal]', function (event) {
        event.preventDefault();

        $.get($(this).data('modal'), function (data) {
            $(data).modal('show');
        });
    });

    // execute scripts in ajax modals
    $(document).on('shown.bs.modal', '.modal-ajax', function () {
        $(this).find('script').each(function(){
            eval($(this).text());
        });
    });

    // remove ajax modal when hidden
    $(document).on('hidden.bs.modal', '.modal-ajax', function () {
        $(this).remove();
    });

    // check all checkboxes
    $(document).on('click', '[data-check-all]', function () {
        $(this).closest('form').find('[name="' + $(this).data('check-all') + '"]').each(function () {
            $(this).prop('checked', true).change();
        });
    });

    // uncheck all checkboxes
    $(document).on('click', '[data-uncheck-all]', function () {
        $(this).closest('form').find('[name="' + $(this).data('uncheck-all') + '"]').each(function () {
            $(this).prop('checked', false).change();
        });
    });

    // hide/show element based on select option
    $(document).on('change', '[data-hide-show]', function () {
        var select = $(this);
        var element = $(select.data('hide-show'));

        element.addClass('d-none');
        element.each(function () {
            if (select.find('option:selected').data('show') === $(this).data('show')) {
                $(this).removeClass('d-none');
            }
        });
    });

    // show time in user timezone
    timezones();
});

function flash(alert_class, alert_message) {
    var html = '<div class="alert alert-' + alert_class + ' alert-fixed mt-3 mb-0">' + alert_message + '</div>';

    $(html).appendTo('body').delay(3000).queue(function () {
        $(this).remove();
    });
}

function timezones() {
    $('.timezone').each(function() {
        if (moment($(this).html(), moment.ISO_8601).isValid()) {
            $(this).html(moment.utc($(this).html()).local().format('YYYY-MM-DD h:mm A'));
        }
    });
}