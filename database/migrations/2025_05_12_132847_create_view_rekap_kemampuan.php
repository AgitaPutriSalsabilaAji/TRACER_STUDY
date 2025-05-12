<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateViewRekapKemampuan extends Migration
{
    public function up(): void
    {
        DB::statement("
           CREATE OR REPLACE VIEW view_rekap_kemampuan AS
            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Kerjasama Tim' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.kerjasama_tim = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.kerjasama_tim = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.kerjasama_tim = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.kerjasama_tim = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Keahlian di Bidang TI' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.keahlian_di_bidang_ti = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.keahlian_di_bidang_ti = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.keahlian_di_bidang_ti = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.keahlian_di_bidang_ti = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Kemampuan Bahasa Asing' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.kemampuan_bahasa_asing = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.kemampuan_bahasa_asing = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.kemampuan_bahasa_asing = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.kemampuan_bahasa_asing = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Kemampuan Komunikasi' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.kemampuan_komunikasi = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.kemampuan_komunikasi = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.kemampuan_komunikasi = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.kemampuan_komunikasi = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Pengembangan Diri' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.pengembangan_diri = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.pengembangan_diri = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.pengembangan_diri = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.pengembangan_diri = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Kepemimpinan' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.kepemimpinan = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.kepemimpinan = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.kepemimpinan = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.kepemimpinan = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus

            UNION

            SELECT 
                a.program_studi_id,
                l.tahun_lulus,
                'Etos Kerja' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN sk.etos_kerja = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN sk.etos_kerja = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN sk.etos_kerja = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN sk.etos_kerja = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan sk
            JOIN alumni a ON a.id = sk.alumni_id
            JOIN lulusan l on l.alumni_id = a.id  
            GROUP BY a.program_studi_id, l.tahun_lulus;

        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_rekap_kemampuan");
    }
}
