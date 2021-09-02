$(function() {
    var start = moment();
    var end = moment();
    let label = "Today";

    $(function() {
        daterange();
        function daterange(){
            $('#daterange').daterangepicker({
                autoUpdateInput: false,
                locale: {cancelLabel: 'Clear'},
                startDate: start,
                endDate: end,
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },cb);
            cb(start, end,label); 
        }
        function cb(start,end,label) {
            $('input[name="daterange"]').val(label);
            $('input[name="daterange"]').attr('data-startdate',start.format('YYYY-MM-DD'));
            $('input[name="daterange"]').attr('data-enddate',end.format('YYYY-MM-DD'));
            let filter_kategori = $('select[name="kategori_filter"] option:selected').val();
            let filter_pegawai = $('select[name="pegawai_filter"] option:selected').val();
            filter(filter_pegawai, filter_kategori, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
        }
        $('#kategori_filter').change(function() {
            daterange();
        });
        $('#pegawai_filter').change(function() {
            daterange();
        });
    });

    function filter(pegawai,kategori,start,end){
        $.ajax({
            url: "dashboard/ajax_dashboard",
            method: "POST",
            dataType: 'json',
            data: {
                'pegawai': pegawai,
                'kategori': kategori,
                'start_date': start,
                'end_date': end,
            },
            success: function (data) {
                if (data.massage == "success") {
                    document.getElementById("tgl_tampil").innerHTML = data.monthSensor;
                    document.getElementById("total_sensor").innerHTML = data.totalSensor;
                    kategoriSensor(data.dataKategori);
                    kategoriPegawai(data.dataPegawai);
                    diagramMorris(data.dataMorris);
                    diagramDonut(data.dataDonut);
                }
            },
        });
    }

    function kategoriSensor(dataKategori){
        $("#kategori_sensor tbody").html('');
        var html = "";
        for(var i=0; i<dataKategori.length; i++){
            html += '<tr><td style="width: 100%; font-size:12px; height:40px;">'+ dataKategori[i].kategori +'</td><td style="font-size:13px; height:40px;">'+ dataKategori[i].value +'</td></tr>';
        }
        if(dataKategori == 0){
            $("#kategori_sensor tbody").html( '<tr><td style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;"><center>Data tidak ditemukan!</center></td></tr>');
        }else{
            $("#kategori_sensor tbody").html(html);
        }
    }

    function kategoriPegawai(dataPegawai){
        $("#kategori_pegawai tbody").html('');
        var html = "";
        for(var i=0; i<dataPegawai.length; i++){
            html += '<tr><td style="width: 100%; font-size:14px; height:40px;">'+ dataPegawai[i].pegawai +'</td><td style="font-size:13px; height:40px;">'+ dataPegawai[i].value +'</td></tr>';
        }
        if(dataPegawai == 0){
            $("#kategori_pegawai tbody").html( '<tr><td style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;"><center>Data tidak ditemukan!</center></td></tr>');
        }else{
            $("#kategori_pegawai tbody").html(html);
        }
    }

    function diagramMorris(dataMorris){
        $('#morrisLine').html('');
        new Morris.Line({
            element: 'morrisLine',
            data: dataMorris,
            xkey:'tanggal',
            ykeys:['value'],
            labels:['value'],
            lineColors: ['#f77eb9'],
            gridLineColor: ['rgba(77, 138, 240, .2)'],
        });
    }

    function diagramDonut(dataDonut){
        $('#doughnutChart').remove();
        $('#tableDonut').append('<canvas id="doughnutChart" style="width: 50%; height: 50%"></canvas>');
        new Chart(doughnutChart, {
            type: "doughnut",
            data: dataDonut,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "bottom",
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                          var dataset = data.datasets[tooltipItem.datasetIndex];
                          var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                          var total = meta.total;
                          var currentValue = dataset.data[tooltipItem.index];
                          var percentage = parseFloat((currentValue/total*100).toFixed(1));
                          return percentage + '%';
                        },
                        title: function(tooltipItem, data) {
                          return data.labels[tooltipItem[0].index];
                        }
                      }
                }
            },
        });
    }

});