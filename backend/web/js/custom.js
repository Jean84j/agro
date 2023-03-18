"use strict";

/*
// Table of content
// - Search AJAX settings
// - Search debounce
// - Search simulate no results
// - Datatables
// - Analytics chart
// - Widget chart (.saw-chart)
// - Widget circle chart (.saw-chart-circle)
// - Feather
// - Range filter
*/

(function($, window){
    /*
    // Search AJAX settings
    */
    window.stroyka.search.getAjaxSettings = function(query) {
        return {
            url: '/shop-admin/app/default/suggestions?search=' + encodeURIComponent(query),
        };
    };

    /*
    // Search debounce
    */
    window.stroyka.search.requestMiddleware.add(function(next, query, abortController) {
        return new Promise(function(resolve) {
            const timer = setTimeout(function() {
                resolve(next(query, abortController));
            }, 500);

            abortController.add(function() {
                clearTimeout(timer);
            });
        });
    });

    /*
    // Search simulate no results
    */
    window.stroyka.search.requestMiddleware.add(function(next, query, abortController) {
        if (query.length >= 15) {
            return Promise.resolve('');
        } else {
            return Promise.resolve(next(query, abortController));
        }
    });

    /*
    // Datatables
    */
    (function() {
        $.fn.DataTable.ext.pager.numbers_length = 5;
        $.fn.DataTable.defaults.oLanguage.sInfo = 'Показано _START_ от _END_ до _TOTAL_';
        $.fn.DataTable.defaults.oLanguage.sLengthMenu = 'Строк на странице _MENU_';

        const template = '' +
            '<"sa-datatables"' +
                '<"sa-datatables__table"t>' +
                '<"sa-datatables__footer"' +
                    '<"sa-datatables__pagination"p>' +
                    '<"sa-datatables__controls"' +
                        '<"sa-datatables__legend"i>' +
                        '<"sa-datatables__divider">' +
                        '<"sa-datatables__page-size"l>' +
                    '>' +
                '>' +
            '>';

            $('.sa-datatables-init').each(function() {
            const tableSearchSelector = $(this).data('sa-search-input');
            const table = $(this).DataTable({
                
                dom: template,
                paging: true,
                ordering: false,
                // order: [[0, 'asc']],
                "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "Все"] ],
                "language": {
                    "paginate": {
                      "next": "Следующая",
                      "previous": "Предыдущая"
                    },
                    "infoFiltered": " - отфильтровано из _MAX_ записей",
                         "loadingRecords": "Подождите, идет загрузка...",
                  },
                drawCallback: function() {
                    $(this.api().table().container()).find('.pagination').addClass('pagination-sm');
                },
            });

            if (tableSearchSelector) {
                $(tableSearchSelector).on('input', function() {
                    table.search(this.value).draw();
                });
            }
        });
        
    })();

    (function() {
        $.fn.DataTable.ext.pager.numbers_length = 5;
        $.fn.DataTable.defaults.oLanguage.sInfo = 'Показано _START_ от _END_ до _TOTAL_';
        $.fn.DataTable.defaults.oLanguage.sLengthMenu = 'Строк на странице _MENU_';

        const template = '' +
            '<"sa-datatables"' +
                '<"sa-datatables__table"t>' +
                '<"sa-datatables__footer"' +
                    // '<"sa-datatables__pagination"p>' +
                    '<"sa-datatables__controls"' +
                        '<"sa-datatables__legend"i>' +
                        // '<"sa-datatables__divider">' +
                        // '<"sa-datatables__page-size"l>' +
                    '>' +
                '>' +
            '>';

            $('.sa-datatables-order-parts').each(function() {
            const tableSearchSelector = $(this).data('id');
            const table = $(this).DataTable({
                
                dom: template,
                paging: true,
                ordering: true,
                "language": {
                    
                  },
                drawCallback: function() {
                    $(this.api().table().container()).find('.pagination').addClass('pagination-sm');
                },
            });

            if (tableSearchSelector) {
                $(tableSearchSelector).on('input', function() {
                    console.log(this.value);
                    table.search(this.value).draw();
                });
            }
        });
        
    })();

    /*
    // Analytics chart
    */
    (function() {
        const chartCanvas = document.getElementById('example-chart-js-analytics');

        if (!chartCanvas) {
            return;
        }

        new Chart(chartCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        backgroundColor: window.stroyka.colors.getThemeColor(),
                        borderColor: 'transparent',
                        borderWidth: 0,
                        fill: 'origin',
                        data: [
                            (10 / 240) * 1200,
                            (26 / 240) * 1200,
                            (105 / 240) * 1200,
                            (57 / 240) * 1200,
                            (94 / 240) * 1200,
                            (26 / 240) * 1200,
                            (57 / 240) * 1200,
                            (48 / 240) * 1200,
                            (142 / 240) * 1200,
                            (94 / 240) * 1200,
                            (128 / 240) * 1200,
                            (222 / 240) * 1200,
                        ],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false,
                    },
                },

                scales: {
                    y: {
                        ticks: {
                            fontFamily: 'Roboto',
                            fontSize: 13,
                            fontColor: '#828f99',
                            // Include a dollar sign in the ticks
                            callback: function (value) {
                                return '₴' + value;
                            },
                        },
                        gridLines: {
                            lineWidth: 1,
                            color: 'rgba(0, 0, 0, 0.1)',
                            zeroLineWidth: 1,
                            zeroLineColor: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false,
                        },
                    },
                    x: {
                        ticks: {
                            fontFamily: 'Roboto',
                            fontSize: 13,
                            fontColor: '#828f99',
                        },
                        gridLines: {
                            display: false,
                        },
                    },
                },
            },
        });
    }());

    /*
    // Widget chart (.saw-chart)
    */
    (function() {
        $('.saw-chart[data-sa-data]').each(function() {
            const data = $(this).data('sa-data');
            const labels = data.map(function(item) { return item.label; });
            const values = data.map(function(item) { return item.value; });
            const canvas = $(this).find('canvas')[0];

            new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            backgroundColor: window.stroyka.colors.getThemeColor(),
                            borderColor: 'transparent',
                            borderWidth: 0,
                            fill: 'origin',
                            data: values,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false,
                        },
                    },

                    scales: {
                        y: {
                            ticks: {
                                fontFamily: 'Roboto',
                                fontSize: 13,
                                fontColor: '#828f99',
                                callback: function (value) {
                                    return '₴ ' + value;
                                },
                            },
                            gridLines: {
                                lineWidth: 1,
                                color: 'rgba(0, 0, 0, 0.1)',
                                zeroLineWidth: 1,
                                zeroLineColor: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false,
                            },
                        },
                        x: {
                            ticks: {
                                fontFamily: 'Roboto',
                                fontSize: 13,
                                fontColor: '#828f99',
                            },
                            gridLines: {
                                display: false,
                            },
                        },
                    },
                },
            });
        });
    }());

    /*
    // Widget circle chart (.saw-chart-circle)
    */
    $('.saw-chart-circle[data-sa-data]').each(function() {
        const data = $(this).data('sa-data');
        const labels = data.map(function(item) { return item.label; });
        const values = data.map(function(item) { return item.value; });
        const colors = data.map(function(item) { return item.color; });
        const canvas = $(this).find('canvas')[0];

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        borderColor: '#fff',
                        hoverBorderColor: '#fff',
                        borderWidth: 2,
                        fill: 'origin',
                        data: values,
                        backgroundColor: colors,
                        hoverBackgroundColor: colors,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    });

    /*
    // Feather
    */
    feather.replace({
        width: '1em',
        height: '1em',
    });

    /*
    // Range filter
    */
    $('.sa-filter-range').each(function() {
        const min = $(this).data('min');
        const max = $(this).data('max');
        const from = $(this).data('from');
        const to = $(this).data('to');
        const slider = this.querySelector('.sa-filter-range__slider');

        stroyka.nouislider.create(slider, {
            start: [from, to],
            connect: true,
            range: {
                'min': min,
                'max': max
            },
            tooltips: true,
            pips: {
                mode: 'count',
                values: 5,
                density: 3,
                stepped: true,
            }
        });

        const inputs = [
            $(this).find('.sa-filter-range__input-from')[0],
            $(this).find('.sa-filter-range__input-to')[0]
        ];

        slider.noUiSlider.on('update', function (values, handle) {
            inputs[handle].value = values[handle];
        });
    });

    $(document).ready(function () {
    $(".plus").click(function () {
        $(this).toggleClass("minus").siblings("ul").toggle();
    })

    $("input[type=checkbox]").click(function () {
        //alert($(this).attr("id"));
        //var sp = $(this).attr("id");
        //if (sp.substring(0, 4) === "c_bs" || sp.substring(0, 4) === "c_bf") {
            $(this).siblings("ul").find("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        //}
    })

    $("input[type=checkbox]").change(function () {
        var sp = $(this).attr("id");
        if (sp.substring(0, 4) === "c_io") {
            var ff = $(this).parents("ul[id^=bf_l]").attr("id");
            if ($('#' + ff + ' > li input[type=checkbox]:checked').length == $('#' + ff + ' > li input[type=checkbox]').length) {
                $('#' + ff).siblings("input[type=checkbox]").prop('checked', true);
                check_fst_lvl(ff);
            }
            else {
                $('#' + ff).siblings("input[type=checkbox]").prop('checked', false);
                check_fst_lvl(ff);
            }
        }

        if (sp.substring(0, 4) === "c_bf") {
            var ss = $(this).parents("ul[id^=bs_l]").attr("id");
            if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
                $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
                check_fst_lvl(ss);
            }
            else {
                $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
                check_fst_lvl(ss);
            }
        }
    });

})

function check_fst_lvl(dd) {
    //var ss = $('#' + dd).parents("ul[id^=bs_l]").attr("id");
    var ss = $('#' + dd).parent().closest("ul").attr("id");
    if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
        //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', true);
        $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
    }
    else {
        //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', false);
        $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
    }

}

function pageLoad() {
    $(".plus").click(function () {
        $(this).toggleClass("minus").siblings("ul").toggle();
    })
}



}(jQuery, window));