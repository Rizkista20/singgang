(function ($) {
	var table_pegawai = $("#datatable_pegawai").DataTable({
		ajax: {
			url: "dashboard/read_pegawai",
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
			emptyTable: "Belum ada pegawai!",
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
				messageTop: "List Pegawai",
			},
			{
				extend: "print",
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-print mr-2"></i> Print',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
				messageTop: "List Pegawai",
			},
			{
				className: "btn btn-secondary wid-max-select text-white",
				text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
				action: function (e, dt, node, config) {
					table_pegawai.ajax.reload();
				},
			},
		],
		bAutoWidth: false,
		columns: [
			{ data: "No" },
			{ data: "Nama" },
			{ data: "Email" },
			{ data: "NoHp" },
			{ data: "Alamat" },
            { data: "Status",render : function ( data, type, row, meta ) {
                let html = '';
                if(data =='1'){
                    html = '<button class="btn btn-warning" style="padding:3px 15px 3px 15px;">Aktif</button>';
                }else if(data =='2'){
                    html ='<button class="btn btn-danger" style="padding:3px 15px 3px 15px;">Tidak Aktif</button>';
                }
                return type === 'display'  ?
                 ''+html:
                  data;
            }},
			{ data: "Aksi",
				render: function (data, type, row, meta) {
					return type === "display"
						? '<a data-id="' +
								data +
								'" id="edit_pegawai" class="text-success mr-4" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>' +
								'<a data-id="' +
								data +
								'" id="hapus_pegawai" class="text-danger" title="Delete" data-toggle="tooltip"><i class="fas fa-trash-alt"></i></a>'
						: data;
				},
			},
		],
	});

    $("body").on("click", "#tambah_pegawai", function () {
		$("#PegawaiAdd").modal();
		$('input[name="nama"]').val("");
		$('input[name="email"]').val("");
		$('input[name="no_hp"]').val("");
		$('input[name="alamat"]').val("");
		$('select[name="status"]').val("");

		$('input[name="edit_Pegawai"]').attr("type", "hidden");
		$('input[name="add_Pegawai"]').attr("type", "text");

		$("body").on("click", "input#add_Pegawai", function () {
			let nama = $('input[name="nama"]').val();
			let email = $('input[name="email"]').val();
			let no_hp = $('input[name="no_hp"]').val();
			let alamat = $('input[name="alamat"]').val();
			let status = $('select[name="status"] > option:selected').val();

			$.ajax({
				url: "dashboard/create_pegawai",
				method: "POST",
				data: {
					nama: nama,
					email: email,
                    no_hp: no_hp,
					alamat: alamat,
                    status: status
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Pegawai Berhasil di Tambah!", {
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
						swal("Gagal", "Pegawai Gagal di Tambah!", {
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

	$("#datatable_pegawai tbody").on("click", "#edit_pegawai", function () {
		$("#PegawaiAdd").modal();
		var id_pegawai = $(this).data("id");
		var data = table_pegawai.row($(this).parents("tr")).data();
		$('input[name="nama"]').val(data["Nama"]);
		$('input[name="email"]').val(data["Email"]);
		$('input[name="no_hp"]').val(data["NoHp"]);
		$('input[name="alamat"]').val(data["Alamat"]);
		$('select[name="status"]').val(data["Status"]);

		$('input[name="edit_Pegawai"]').attr("type", "text");
		$('input[name="add_Pegawai"]').attr("type", "hidden");

		$("body").on("click", "input#edit_Pegawai", function () {
			let nama = $('input[name="nama"]').val();
			let email = $('input[name="email"]').val();
			let no_hp = $('input[name="no_hp"]').val();
			let alamat = $('input[name="alamat"]').val();
            let status = $('select[name="status"] option:selected').val();

			$.ajax({
				url: "dashboard/update_pegawai",
				method: "POST",
				data: {
					id_pegawai: id_pegawai,
					nama: nama,
					email: email,
                    no_hp: no_hp,
					alamat: alamat,
                    status: status
				},
				success: function (response) {
					if (response == "success") {
						swal("Berhasil", "Pegawai Berhasil di Ganti!", {
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
						swal("Gagal", "Pegawai Gagal di Ganti!", {
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
	
	$("#datatable_pegawai tbody").on("click", "#hapus_pegawai", function () {
		var id_pegawai = $(this).data("id");
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
					url: "dashboard/delete_pegawai",
					method: "POST",
					data: {
						id_pegawai: id_pegawai,
					},
					success: function (response) {
						if (response == "success") {
							swal("Berhasil", "Pegawai Berhasil di Hapus!", {
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
							swal("Gagal", "Pegawai Gagal di Hapus!", {
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
