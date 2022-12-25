var TableDatatablesButtons = function () {
	var initTable1 = function () {
        var table = $('.sample_1');
        var oTable = table.dataTable({
            "language": {
               url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Persian.json'
            },
            buttons: [
                { extend: 'print', className: 'btn dark',autoPrint: true},
                { extend: 'copy', className: 'btn red' },
                { extend: 'pdf', className: 'btn green' },
                { extend: 'excel', className: 'btn yellow' },
                { extend: 'csv', className: 'btn purple' },
                { extend: 'colvis', className: 'btn dark', text: 'Columns'}
            ],
            responsive: false,
			"ordering": false,
			"paging": false,
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    }
    var initTable2 = function () {
        var table = $('.sample_2');
        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
               url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Persian.json'
            },
            buttons: [
                { extend: 'print', className: 'btn default' },
                { extend: 'copy', className: 'btn default' },
                { extend: 'pdf', className: 'btn default' },
                { extend: 'excel', className: 'btn default' },
                { extend: 'csv', className: 'btn default' },
                {
                    text: 'Reload',
                    className: 'btn default',
                    action: function ( e, dt, node, config ) {
                        //dt.ajax.reload();
                        alert('Custom Button');
                    }
                }
            ],
            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 30,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
			initTable1();
            initTable2();
        }
    };
}();
jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});