(function ($) {
	var table_kategori = $("#datatable_kategori").DataTable({
		ajax: {
			url: "dashboard/read_kategori",
			type: "GET",
		},
		aLengthMenu: [
			[10, 30, 50, -1],
			[10, 30, 50, "All"],
		],
		order: [],
		processing: true,
		language: {
			search: '<i class="fa fa-search"></i>',
			searchPlaceholder: "Cari",
			emptyTable: "Belum ada kategori!",
		},
		dom: '<"toolbardate_report"><Bfrtip><"bottom mb-4 text-center"l> ',
		buttons: [
			{
				extend: "pdf",
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
				messageTop: "List Kategori",
			},
			{
				extend: "print",
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-print mr-2"></i> Print',
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
				messageTop: "List Kategori",
			},
			{
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
				action: function (e, dt, node, config) {
					table_kategori.ajax.reload();
				},
			},
		],
		bAutoWidth: false,
		columns: [
			{ data: "No" },
			{ data: "Kategori" },
			{ data: "Sensor" },
			{ data: "Socket" },
			{ data: "Aksi",
				render: function (data, type, row, meta) {
					return type === "display"
						? '<a data-id="' +
								data +
								'" id="edit_kategori" class="text-success mr-4" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>' +
								'<a data-id="' +
								data +
								'" id="hapus_kategroi" class="text-danger" title="Delete" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>'
						: data;
				},
			},
		],
	});

    $("body").on("click", "#tambah_kategori", function () {
		$("#KategoriAdd").modal();
		$('input[name="kategori"]').val("");
		$('input[name="sensor"]').val("");
		$('input[name="socket"]').val("");

		$('input[name="edit_Kategori"]').attr("type", "hidden");
		$('input[name="add_Kategori"]').attr("type", "text");

		$("body").on("click", "input#add_Kategori", function () {
			var id_kategori = $(this).data("id");
			let kategori = $('input[name="kategori"]').val();
			let sensor = $('input[name="sensor"]').val();
			let socket = $('input[name="socket"]').val();

			$.ajax({
				url: "dashboard/create_kategori",
				method: "POST",
				data: {
					id_kategori: id_kategori,
					kategori: kategori,
					sensor: sensor,
					socket: socket,
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Kategori Berhasil di Tambah!", {
							icon: "success",
							buttons: {
								confirm: {
									className: "btn btn-success",
								},
							},
						});
						setTimeout(() => {
							window.location.reload();
						}, 1000);
					} else {
						swal("Gagal", "Kategori Gagal di Tambah!", {
							icon: "error",
							buttons: {
								confirm: {
									className: "btn btn-danger",
								},
							},
						});
					}
				},
			});
		});
	});

	$("#datatable_kategori tbody").on("click", "#edit_kategori", function () {
		$("#KategoriAdd").modal();
		var id_kategori = $(this).data("id");
		var data = table_kategori.row($(this).parents("tr")).data();
		$('input[name="kategori"]').val(data["Kategori"]);
		$('input[name="sensor"]').val(data["Sensor"]);
		$('input[name="socket"]').val(data["Socket"]);

		$('input[name="edit_Kategori"]').attr("type", "text");
		$('input[name="add_Kategori"]').attr("type", "hidden");

		$("body").on("click", "input#edit_Kategori", function () {
			let kategori = $('input[name="kategori"]').val();
			let sensor = $('input[name="sensor"]').val();
			let socket = $('input[name="socket"]').val();

			$.ajax({
				url: "dashboard/update_kategori",
				method: "POST",
				data: {
					id_kategori: id_kategori,
					kategori: kategori,
					sensor: sensor,
					socket: socket,
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Kategori Berhasil di Ganti!", {
							icon: "success",
							buttons: {
								confirm: {
									className: "btn btn-success",
								},
							},
						});
						setTimeout(() => {
							window.location.reload();
						}, 1000);
					} else {
						swal("Gagal", "Kategori Gagal di Ganti!", {
							icon: "error",
							buttons: {
								confirm: {
									className: "btn btn-danger",
								},
							},
						});
					}
				},
			});
		});
	});
	
	$("#datatable_kategori tbody").on("click", "#hapus_kategroi", function () {
		var id_kategori = $(this).data("id");
		swal({
			title: "Apakah anda yakin?",
			text: "Data yang telah dihapus tidak dapat dikembalikan lagi!",
			type: "warning",
			buttons: {
				confirm: {
					text: "Ya Hapus",
					className: "btn btn-success",
				},
				cancel: {
					visible: true,
					text: "Batal",
					className: "btn btn-danger",
				},
			},
		}).then((Delete) => {
			if (Delete) {
				$.ajax({
					url: "dashboard/delete_kategori",
					method: "POST",
					data: {
						id_kategori: id_kategori,
					},
					success: function (response) {
						if (response == "success") {
							swal("Berhasil", "Kategori Berhasil di Hapus!", {
								icon: "success",
								buttons: {
									confirm: {
										className: "btn btn-success",
									},
								},
							});
							setTimeout(() => {
								window.location.reload();
							}, 1000);
						} else {
							swal("Gagal", "Kategori Gagal di Hapus!", {
								icon: "error",
								buttons: {
									confirm: {
										className: "btn btn-danger",
									},
								},
							});
						}
					},
				});
			} else {
				swal.close();
			}
		});
	});

})(jQuery);
