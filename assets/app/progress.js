(function ($) {
	var table_progress = $("#datatable_progress").DataTable({
		ajax: {
			url: "dashboard/read_progress",
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
			emptyTable: "Belum ada progress!",
		},
		dom: '<"toolbardate_report"><Bfrtip><"bottom mb-4 text-center"l> ',
		buttons: [
			{
				extend: "pdf",
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
				messageTop: "List Progress",
			},
			{
				extend: "print",
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-print mr-2"></i> Print',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
				messageTop: "List Progress",
			},
			{
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
				action: function (e, dt, node, config) {
					table_progress.ajax.reload();
				},
			},
		],
		bAutoWidth: false,
		columns: [
			{ data: "No" },
			{ data: "Pegawai" },
			{ data: "Kategori" },
			{ data: "Jumlah" },
			{ data: "Tanggal" },
			{ data: "Aksi",
				render: function (data, type, row, meta) {
					return type === "display"
						? '<a data-id="' +
								data +
								'" id="edit_progress" class="text-success mr-4" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>' +
								'<a data-id="' +
								data +
								'" id="hapus_progress" class="text-danger" title="Delete" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>'
						: data;
				},
			},
		],
	});



    $("body").on("click", "#tambah_progress", function () {
		$("#ProgressAdd").modal();
		$('select[name="pegawai"]').val("");
		$('select[name="kategori"]').val("");
		$('input[name="jumlah"]').val("");
		$('input[name="tanggal"]').val(moment().format("YYYY-MM-DD"));

		$('input[name="edit_Progress"]').attr("type", "hidden");
		$('input[name="add_Progress"]').attr("type", "text");

		$("body").on("click", "input#add_Progress", function () {
			let pegawai = $('select[name="pegawai"] > option:selected').val();
			let kategori = $('select[name="kategori"] > option:selected').val();
			let jumlah = $('input[name="jumlah"]').val();
			let tanggal = $('input[name="tanggal"]').val();

			$.ajax({
				url: "dashboard/create_progress",
				method: "POST",
				data: {
					pegawai: pegawai,
					kategori: kategori,
                    jumlah: jumlah,
					tanggal: tanggal
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Progress Berhasil di Tambah!", {
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
					} else if (response == "data_sudah_ada") {
						swal("Gagal", "Progress Sudah Ada!", {
							icon: "error",
							buttons: {
								confirm: {
									className: "btn btn-danger",
								},
							},
						});
					} else {
						swal("Gagal", "Progress Gagal di Tambah!", {
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

	$("#datatable_progress tbody").on("click", "#edit_progress", function () {
		$("#ProgressAdd").modal();
		var id_progress = $(this).data("id");
		var data = table_progress.row($(this).parents("tr")).data();
		$('select[name="pegawai"]').val(data["id_pengguna"]);
		$('select[name="kategori"]').val(data["id_kategori"]);
		$('input[name="jumlah"]').val(data["Jumlah"]);
		$('input[name="tanggal"]').val(data["Tanggal"]);

		$('input[name="edit_Progress"]').attr("type", "text");
		$('input[name="add_Progress"]').attr("type", "hidden");

		$("body").on("click", "input#edit_Progress", function () {
			let pegawai = $('select[name="pegawai"] > option:selected').val();
			let kategori = $('select[name="kategori"] > option:selected').val();
			let jumlah = $('input[name="jumlah"]').val();
			let tanggal = $('input[name="tanggal"]').val();

			$.ajax({
				url: "dashboard/update_progress",
				method: "POST",
				data: {
					id_progress: id_progress,
					pegawai: pegawai,
					kategori: kategori,
                    jumlah: jumlah,
					tanggal: tanggal
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Progress Berhasil di Ganti!", {
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
						swal("Gagal", "Progress Gagal di Ganti!", {
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
	
	$("#datatable_progress tbody").on("click", "#hapus_progress", function () {
		var id_progress = $(this).data("id");
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
					url: "dashboard/delete_progress",
					method: "POST",
					data: {
						id_progress: id_progress,
					},
					success: function (response) {
						if (response == "success") {
							swal("Berhasil", "Progress Berhasil di Hapus!", {
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
							swal("Gagal", "Progress Gagal di Hapus!", {
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

	$('#tanggal').datepicker({ format: 'yyyy-mm-dd' }).on('changeDate', function() { $(this).datepicker('hide') });
})(jQuery);