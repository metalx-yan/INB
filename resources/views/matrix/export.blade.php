<?php 
    $filename = 'export.xls';
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename='. $filename);

        $totalcurl1 = DB::connection('sqlsrv158')->table('db_reza.dbo.grafik_cur_balance')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(saldo as BIGINT)) as balance'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.grafik_cur_balance.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show1 = $totalcurl1->where('db_reza.dbo.grafik_cur_balance.region','LIKE', $_GET["region"]);
                } else {
                        $show1 = $totalcurl1;
                }

                if ($_GET["type"] != null) {
                        $show1 = $totalcurl1->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show1 = $totalcurl1;
                }
                
                if ($_GET["group"] != null ) {
                        $show1 = $totalcurl1->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show1 = $totalcurl1;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show1 = $totalcurl1->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show1 = $totalcurl1;
                }
        
        $quer1 = $show1->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl2 = DB::connection('sqlsrv158')->table('db_reza.dbo.grafik_cur_balance')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(saldo as BIGINT)) as balance'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.grafik_cur_balance.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show2 = $totalcurl2->where('db_reza.dbo.grafik_cur_balance.region','LIKE', $_GET["region"]);
                } else {
                        $show2 = $totalcurl2;
                }

                if ($_GET["type"] != null) {
                        $show2 = $totalcurl2->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show2 = $totalcurl2;
                }
                
                if ($_GET["group"] != null ) {
                        $show2 = $totalcurl2->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show2 = $totalcurl2;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show2 = $totalcurl2->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show2 = $totalcurl2;
                }
        
        $quer2 = $show2->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl3 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(jumlah_acc) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show3 = $totalcurl3->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show3 = $totalcurl3;
                }

                if ($_GET["type"] != null) {
                        $show3 = $totalcurl3->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show3 = $totalcurl3;
                }
                
                if ($_GET["group"] != null ) {
                        $show3 = $totalcurl3->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show3 = $totalcurl3;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show3 = $totalcurl3->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show3 = $totalcurl3;
                }
        $quer3 = $show3->where('note_posisi_produk_pekerjaan', '!=', 'OUT MURNI')->where('db_reza.dbo.tbl_chart_acc_mtd.tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl4 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(jumlah_acc) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show4 = $totalcurl4->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show4 = $totalcurl4;
                }

                if ($_GET["type"] != null) {
                        $show4 = $totalcurl4->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show4 = $totalcurl4;
                }
                
                if ($_GET["group"] != null ) {
                        $show4 = $totalcurl4->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show4 = $totalcurl4;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show4 = $totalcurl4->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show4 = $totalcurl4;
                }
        
        $quer4 = $show4->where('note_posisi_produk_pekerjaan', '!=', 'OUT MURNI')->where('db_reza.dbo.tbl_chart_acc_mtd.tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl5 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show5 = $totalcurl5->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show5 = $totalcurl5;
                }

                if ($_GET["type"] != null) {
                        $show5 = $totalcurl5->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show5 = $totalcurl5;
                }
                
                if ($_GET["group"] != null ) {
                        $show5 = $totalcurl5->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show5 = $totalcurl5;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show5 = $totalcurl5->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show5 = $totalcurl5;
                }
        $quer5 = $show5->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl6 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show6 = $totalcurl6->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show6 = $totalcurl6;
                }

                if ($_GET["type"] != null) {
                        $show6 = $totalcurl6->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show6 = $totalcurl6;
                }
                
                if ($_GET["group"] != null ) {
                        $show6 = $totalcurl6->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show6 = $totalcurl6;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show6 = $totalcurl6->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show6 = $totalcurl6;
                }
        $quer6 = $show6->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl7 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show7 = $totalcurl7->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show7 = $totalcurl7;
                }

                if ($_GET["type"] != null) {
                        $show7 = $totalcurl7->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show7 = $totalcurl7;
                }
                
                if ($_GET["group"] != null ) {
                        $show7 = $totalcurl7->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show7 = $totalcurl7;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show7 = $totalcurl7->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show7 = $totalcurl7;
                }
        $quer7 = $show7->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl8 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show8 = $totalcurl8->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show8 = $totalcurl8;
                }

                if ($_GET["type"] != null) {
                        $show8 = $totalcurl8->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show8 = $totalcurl8;
                }
                
                if ($_GET["group"] != null ) {
                        $show8 = $totalcurl8->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show8 = $totalcurl8;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show8 = $totalcurl8->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show8 = $totalcurl8;
                }

        $quer8 = $show8->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        

        $totalcurl9 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show9 = $totalcurl9->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show9 = $totalcurl9;
                }

                if ($_GET["type"] != null) {
                        $show9 = $totalcurl9->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show9 = $totalcurl9;
                }
                
                if ($_GET["group"] != null ) {
                        $show9 = $totalcurl9->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show9 = $totalcurl9;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show9 = $totalcurl9->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show9 = $totalcurl9;
                }
        $quer9 = $show9->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl10 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show10 = $totalcurl10->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show10 = $totalcurl10;
                }

                if ($_GET["type"] != null) {
                        $show10 = $totalcurl10->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show10 = $totalcurl10;
                }
                
                if ($_GET["group"] != null ) {
                        $show10 = $totalcurl10->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show10 = $totalcurl10;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show10 = $totalcurl10->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show10 = $totalcurl10;
                }
        $quer10 = $show10->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl11 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show11 = $totalcurl11->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show11 = $totalcurl11;
                }

                if ($_GET["type"] != null) {
                        $show11 = $totalcurl11->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show11 = $totalcurl11;
                }
                
                if ($_GET["group"] != null ) {
                        $show11 = $totalcurl11->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show11 = $totalcurl11;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show11 = $totalcurl11->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show11 = $totalcurl11;
                }
        $quer11 = $show11->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl12 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(jumlah_acc as BIGINT)) as total'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show12 = $totalcurl12->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show12 = $totalcurl12;
                }

                if ($_GET["type"] != null) {
                        $show12 = $totalcurl12->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show12 = $totalcurl12;
                }
                
                if ($_GET["group"] != null ) {
                        $show12 = $totalcurl12->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show12 = $totalcurl12;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show12 = $totalcurl12->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show12 = $totalcurl12;
                }
        $quer12 = $show12->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl13 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show13 = $totalcurl13->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show13 = $totalcurl13;
                }

                if ($_GET["type"] != null) {
                        $show13 = $totalcurl13->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show13 = $totalcurl13;
                }
                
                if ($_GET["group"] != null ) {
                        $show13 = $totalcurl13->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show13 = $totalcurl13;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show13 = $totalcurl13->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show13 = $totalcurl13;
                }
        $quer13 = $show13->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl14 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show14 = $totalcurl14->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show14 = $totalcurl14;
                }

                if ($_GET["type"] != null) {
                        $show14 = $totalcurl14->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show14 = $totalcurl14;
                }
                
                if ($_GET["group"] != null ) {
                        $show14 = $totalcurl14->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show14 = $totalcurl14;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show14 = $totalcurl14->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show14 = $totalcurl14;
                }
        $quer14 = $show14->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl15 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show15 = $totalcurl15->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show15 = $totalcurl15;
                }

                if ($_GET["type"] != null) {
                        $show15 = $totalcurl15->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show15 = $totalcurl15;
                }
                
                if ($_GET["group"] != null ) {
                        $show15 = $totalcurl15->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show15 = $totalcurl15;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show15 = $totalcurl15->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show15 = $totalcurl15;
                }
        $quer15 = $show15->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl16 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(awal as BIGINT)) as start'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show16 = $totalcurl16->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show16 = $totalcurl16;
                }

                if ($_GET["type"] != null) {
                        $show16 = $totalcurl16->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show16 = $totalcurl16;
                }
                
                if ($_GET["group"] != null ) {
                        $show16 = $totalcurl16->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show16 = $totalcurl16;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show16 = $totalcurl16->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show16 = $totalcurl16;
                }
        $quer16 = $show16->where('note_posisi_produk_pekerjaan', '=', 'OUT MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl17 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show17 = $totalcurl17->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show17 = $totalcurl17;
                }

                if ($_GET["type"] != null) {
                        $show17 = $totalcurl17->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show17 = $totalcurl17;
                }
                
                if ($_GET["group"] != null ) {
                        $show17 = $totalcurl17->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show17 = $totalcurl17;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show17 = $totalcurl17->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show17 = $totalcurl17;
                }
        $quer17 = $show17->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl18 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_mtd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_mtd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show18 = $totalcurl18->where('db_reza.dbo.tbl_chart_acc_mtd.region','LIKE', $_GET["region"]);
                } else {
                        $show18 = $totalcurl18;
                }

                if ($_GET["type"] != null) {
                        $show18 = $totalcurl18->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show18 = $totalcurl18;
                }
                
                if ($_GET["group"] != null ) {
                        $show18 = $totalcurl18->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show18 = $totalcurl18;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show18 = $totalcurl18->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show18 = $totalcurl18;
                }
        $quer18 = $show18->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
        $totalcurl19 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show19 = $totalcurl19->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show19 = $totalcurl19;
                }

                if ($_GET["type"] != null) {
                        $show19 = $totalcurl19->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show19 = $totalcurl19;
                }
                
                if ($_GET["group"] != null ) {
                        $show19 = $totalcurl19->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show19 = $totalcurl19;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show19 = $totalcurl19->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show19 = $totalcurl19;
                }
        $quer19 = $show19->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2018')->groupBy('bulan')->orderBy('bulan', 'asc')->get();

        $totalcurl20 = DB::connection('sqlsrv158')->table('db_reza.dbo.tbl_chart_acc_ytd')->select(DB::raw("CONVERT(INT, bulan) as bulan"), DB::raw('sum(cast(akhir as BIGINT)) as endd'))
                ->leftJoin('funding.dbo.prm_grouping_produk' , 'db_reza.dbo.tbl_chart_acc_ytd.acc_type' , '=' , 'funding.dbo.prm_grouping_produk.Acc_type');

                if ($_GET["region"] != null) {
                        $show20 = $totalcurl20->where('db_reza.dbo.tbl_chart_acc_ytd.region','LIKE', $_GET["region"]);
                } else {
                        $show20 = $totalcurl20;
                }

                if ($_GET["type"] != null) {
                        $show20 = $totalcurl20->where('funding.dbo.prm_grouping_produk.Jenis', $_GET["type"]);
                } else {
                        $show20 = $totalcurl20;
                }
                
                if ($_GET["group"] != null ) {
                        $show20 = $totalcurl20->where('funding.dbo.prm_grouping_produk.group_prod_3', $_GET["group"]);
                } else {
                        $show20 = $totalcurl20;
                }

                if ( $_GET["acctypes"] != null ) {
                        $show20 = $totalcurl20->whereIn('funding.dbo.prm_grouping_produk.acc_type', explode(' ',$_GET["acctypes"]));
                } else {
                        $show20 = $totalcurl20;
                }
        $quer20 = $show20->where('note_posisi_produk_pekerjaan', '=', 'NEW MURNI')->where('tahun', '2019')->groupBy('bulan')->orderBy('bulan', 'asc')->get();
        
?>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Cur Balance</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer2 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer1 as $item)
               <td>{{ $item->balance }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer2 as $item)
                <td>{{ $item->balance }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Total Account</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer4 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer3 as $item)
               <td>{{ $item->total }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer4 as $item)
                <td>{{ $item->total }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Total Closed Account MTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer6 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer5 as $item)
               <td>{{ $item->total }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer6 as $item)
                <td>{{ $item->total }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Total Closed Account YTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer8 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer7 as $item)
               <td>{{ $item->total }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer8 as $item)
                <td>{{ $item->total }}</td>
            @endforeach
        </tr>
</table>


<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Total New Account MTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer10 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer9 as $item)
               <td>{{ $item->total }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer10 as $item)
                <td>{{ $item->total }}</td>
            @endforeach
        </tr>
</table>


<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Total New Account YTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer12 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer11 as $item)
               <td>{{ $item->total }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer12 as $item)
                <td>{{ $item->total }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Closed Account Cur Bal MTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer14 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer13 as $item)
               <td>{{ $item->start }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer14 as $item)
                <td>{{ $item->start }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>Closed Account Cur Bal YTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer16 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer15 as $item)
               <td>{{ $item->start }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer16 as $item)
                <td>{{ $item->start }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>New Account Cur Bal MTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer18 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer17 as $item)
               <td>{{ $item->endd }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer18 as $item)
                <td>{{ $item->endd }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>New Account Cur Bal MTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer18 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer17 as $item)
               <td>{{ $item->endd }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer18 as $item)
                <td>{{ $item->endd }}</td>
            @endforeach
        </tr>
</table>

<br>
<table border="1">
        <tr>
            <td colspan="13"><center>New Account Cur Bal YTD</center></td>
        </tr>
        <tr>
            <td>Periode</td>
            @foreach ($quer20 as $item)
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2018</td>
           @foreach ($quer19 as $item)
               <td>{{ $item->endd }}</td>
           @endforeach
        </tr>
        <tr>
            <td>Saldo Posisi 2019</td>
            @foreach ($quer20 as $item)
                <td>{{ $item->endd }}</td>
            @endforeach
        </tr>
</table>